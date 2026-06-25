<?php

namespace App\Http\Controllers\Admin\inventory_Loan;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Lab;
use App\Models\LabLoan;
use App\Models\LabLoanDetail;
use App\Models\User;
use App\Notifications\LoanRequestedNotification;
use App\Notifications\LoanStatusNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;

/**
 * Class LabLoanController
 *
 * Mengelola proses peminjaman alat/bahan laboratorium dari sisi mahasiswa dan admin.
 * Fitur: pengajuan peminjaman, generate nomor resi, notifikasi, persetujuan/penolakan,
 * pembatalan oleh mahasiswa, serta riwayat peminjaman.
 *
 * Akses: Super Admin & Admin Lab untuk manajemen.
 */
class LabLoanController extends Controller
{
    // ─────────────────────────────────────────
    // MAHASISWA (Sisi Pemohon)
    // ─────────────────────────────────────────

    /**
     * Menampilkan form pengajuan peminjaman untuk mahasiswa.
     * Menampilkan daftar inventaris yang tersedia dan lab yang aktif.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $inventories = Inventory::where('active', true)
            ->where('quantity_available', '>', 0)
            ->orderBy('item_name')
            ->get();

        $labs = Lab::where('active', true)->orderBy('name')->get();

        // Data mahasiswa dari session CIS (sesuaikan key)
        $user = session('cis_user');

        return view('lab-loan.create', compact('inventories', 'labs', 'user'));
    }

    /**
     * Menyimpan pengajuan peminjaman, mengecek stok aktual, dan generate nomor resi.
     * Menggunakan transaksi database untuk menjaga konsistensi.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'borrower_name'        => 'required|string|max:255',
            'nim'                  => 'required|string|max:50',
            'study_program'        => 'required|string|max:255',
            'research_title'       => 'required|string|max:255',
            'planned_borrow_date'  => 'required|date|after_or_equal:today',
            'planned_return_date'  => 'required|date|after:planned_borrow_date',
            'lab_id'               => 'nullable|exists:lab,id',
            'items'                => 'required|array|min:1',
            'items.*.inventory_id' => 'required|exists:inventory,id',
            'items.*.quantity'     => 'required|integer|min:1',
            'items.*.notes'        => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // Cek ketersediaan stok aktual (fisik - reservasi aktif) untuk setiap item
            foreach ($request->items as $item) {
                $inv = Inventory::findOrFail($item['inventory_id']);
                $actualAvailable = $inv->getActualAvailable(); // metode dari model Inventory
                if ($actualAvailable < $item['quantity']) {
                    return back()->withInput()->withErrors([
                        'items' => "Stok {$inv->item_name} tidak mencukupi. Tersedia: {$actualAvailable} {$inv->unit}."
                    ]);
                }
            }

            // Buat record peminjaman utama dengan nomor resi otomatis
            $loan = LabLoan::create([
                'nim'                  => $request->nim,
                'borrower_name'        => $request->borrower_name,
                'study_program'        => $request->study_program,
                'research_title'       => $request->research_title,
                'planned_borrow_date'  => $request->planned_borrow_date,
                'planned_return_date'  => $request->planned_return_date,
                'lab_id'               => $request->lab_id,
                'receipt_number'       => LabLoan::generateReceiptNumber(),
                'status'               => 'pending',
            ]);

            // Simpan detail item yang dipinjam
            foreach ($request->items as $item) {
                LabLoanDetail::create([
                    'lab_loan_id'  => $loan->id,
                    'inventory_id' => $item['inventory_id'],
                    'quantity'     => $item['quantity'],
                    'notes'        => $item['notes'] ?? null,
                ]);
            }

            // Kirim notifikasi ke admin (super_admin dan admin_lab)
            $admins = User::whereIn('role', ['super_admin', 'admin_lab'])->get();
            Notification::send($admins, new LoanRequestedNotification($loan));

            DB::commit();

            return redirect()
                ->route('lab-loan.receipt', $loan->receipt_number)
                ->with('success', 'Pengajuan berhasil! Simpan nomor resi Anda.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan peminjaman: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Menampilkan halaman resi setelah pengajuan berhasil.
     *
     * @param string $receiptNumber
     * @return \Illuminate\View\View
     */
    public function receipt(string $receiptNumber)
    {
        $loan = LabLoan::with(['details.inventory', 'lab'])
            ->where('receipt_number', $receiptNumber)
            ->firstOrFail();

        return view('lab-loan.receipt', compact('loan'));
    }

    /**
     * Cek status peminjaman berdasarkan nomor resi (untuk publik/mahasiswa).
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function checkStatus(Request $request)
    {
        $loan = null;

        if ($request->filled('receipt_number')) {
            $loan = LabLoan::with(['details.inventory', 'lab'])
                ->where('receipt_number', $request->receipt_number)
                ->first();

            if (!$loan) {
                return back()->withErrors(['receipt_number' => 'Nomor resi tidak ditemukan.']);
            }
        }

        return view('lab-loan.check-status', compact('loan'));
    }

    /**
     * Menampilkan riwayat peminjaman mahasiswa berdasarkan NIM dari session.
     *
     * @return \Illuminate\View\View
     */
    public function history()
    {
        $nim   = session('cis_user.nim');
        $loans = LabLoan::with(['details.inventory'])
            ->where('nim', $nim)
            ->latest()
            ->paginate(10);

        return view('lab-loan.history', compact('loans'));
    }

    /**
     * Membatalkan peminjaman oleh mahasiswa (hanya status pending/approved).
     * Hanya pemilik NIM yang dapat membatalkan.
     *
     * @param LabLoan $labLoan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel(LabLoan $labLoan)
    {
        // Pastikan yang membatalkan adalah pemiliknya (sesuai NIM session)
        if (session('cis_user.nim') !== $labLoan->nim) {
            abort(403, 'Anda tidak berhak membatalkan peminjaman ini.');
        }

        // Hanya bisa batalkan jika status pending atau approved (belum handover)
        if (!in_array($labLoan->status, ['pending', 'approved'])) {
            return back()->with('error', 'Peminjaman ini tidak bisa dibatalkan karena sudah diproses lebih lanjut.');
        }

        // Pastikan belum handover (return_date masih null)
        if ($labLoan->return_date) {
            return back()->with('error', 'Barang sudah keluar, tidak bisa dibatalkan.');
        }

        DB::beginTransaction();
        try {
            $labLoan->update([
                'status'      => 'cancelled',
                'admin_notes' => 'Dibatalkan oleh peminjam',
            ]);

            DB::commit();

            return redirect()->route('lab-loan.history')
                ->with('success', 'Peminjaman berhasil dibatalkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal membatalkan peminjaman: ' . $e->getMessage());
            return back()->with('error', 'Gagal membatalkan peminjaman: ' . $e->getMessage());
        }
    }

    // ─────────────────────────────────────────
    // ADMIN LAB & SUPER ADMIN (Sisi Manajemen)
    // ─────────────────────────────────────────

    /**
     * Menampilkan dashboard peminjaman untuk admin dengan filter status dan pencarian.
     * Akses: Super Admin & Admin Lab.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function adminIndex(Request $request)
    {
        $this->authorizeRole(['super_admin', 'admin_lab']);

        $loans = LabLoan::with(['details.inventory', 'lab'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->search, fn($q) => $q->where(function ($q) use ($request) {
                $q->where('borrower_name', 'like', "%{$request->search}%")
                  ->orWhere('nim', 'like', "%{$request->search}%")
                  ->orWhere('receipt_number', 'like', "%{$request->search}%");
            }))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        // Statistik status untuk badge
        $counts = [
            'pending'   => LabLoan::where('status', 'pending')->count(),
            'approved'  => LabLoan::where('status', 'approved')->count(),
            'rejected'  => LabLoan::where('status', 'rejected')->count(),
            'returned'  => LabLoan::where('status', 'returned')->count(),
            'cancelled' => LabLoan::where('status', 'cancelled')->count(),
            'expired'   => LabLoan::where('status', 'expired')->count(),
        ];

        return view('admin.lab_loan.index', compact('loans', 'counts'));
    }

    /**
     * Menampilkan detail peminjaman untuk admin.
     * Akses: Super Admin & Admin Lab.
     *
     * @param LabLoan $labLoan
     * @return \Illuminate\View\View
     */
    public function adminShow(LabLoan $labLoan)
    {
        $this->authorizeRole(['super_admin', 'admin_lab']);
        $labLoan->load(['details.inventory', 'lab']);
        return view('admin.lab_loan.show', compact('labLoan'));
    }

    /**
     * Menyetujui peminjaman (status menjadi approved).
     * Tidak mengurangi stok di sini, stok dikurangi saat barang keluar (handover).
     * Akses: Super Admin & Admin Lab.
     *
     * @param Request $request
     * @param LabLoan $labLoan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve(Request $request, LabLoan $labLoan)
    {
        $this->authorizeRole(['super_admin', 'admin_lab']);

        // Pastikan status masih pending
        if ($labLoan->status !== 'pending') {
            return redirect()->route('admin.loans.index')
                ->with('error', 'Peminjaman ini sudah pernah diproses sebelumnya.');
        }

        try {
            $labLoan->update([
                'status'      => 'approved',
                'admin_notes' => $request->admin_notes ?? $labLoan->admin_notes,
            ]);

            // Kirim notifikasi ke mahasiswa (tidak menggagalkan proses jika gagal)
            try {
                $this->notifyMahasiswa($labLoan);
            } catch (\Exception $e) {
                Log::warning("Notifikasi gagal dikirim: " . $e->getMessage());
            }

            return redirect()->route('admin.loans.index')
                ->with('success', "Peminjaman #{$labLoan->receipt_number} berhasil disetujui.");
        } catch (\Exception $e) {
            Log::error('Gagal approve peminjaman: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    /**
     * Menolak peminjaman (status menjadi rejected).
     * Akses: Super Admin & Admin Lab.
     *
     * @param Request $request
     * @param LabLoan $labLoan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reject(Request $request, LabLoan $labLoan)
    {
        $this->authorizeRole(['super_admin', 'admin_lab']);

        $request->validate([
            'admin_notes' => 'required|string|max:500',
        ], ['admin_notes.required' => 'Alasan penolakan wajib diisi.']);

        if ($labLoan->status !== 'pending') {
            return back()->withErrors(['error' => 'Peminjaman ini sudah diproses.']);
        }

        try {
            $labLoan->update([
                'status'      => 'rejected',
                'admin_notes' => $request->admin_notes,
            ]);

            $this->notifyMahasiswa($labLoan);

            return back()->with('success', "Peminjaman {$labLoan->receipt_number} ditolak.");
        } catch (\Exception $e) {
            Log::error('Gagal reject peminjaman: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menolak peminjaman.');
        }
    }

    // ─────────────────────────────────────────
    // HELPER PRIVATE
    // ─────────────────────────────────────────

    /**
     * Memeriksa apakah user memiliki role yang diizinkan.
     * Jika tidak, abort 403.
     *
     * @param array $roles
     * @return void
     */
    private function authorizeRole(array $roles): void
    {
        if (!in_array(auth()->user()->role, $roles)) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin.');
        }
    }

    /**
     * Mengirim notifikasi ke mahasiswa terkait perubahan status peminjaman.
     * Saat ini belum diimplementasikan, hanya placeholder untuk pengembangan.
     *
     * @param LabLoan $loan
     * @return void
     */
    private function notifyMahasiswa(LabLoan $loan): void
    {
        // Implementasi notifikasi akan ditambahkan di sini
        // Contoh: $loan->mahasiswa->notify(new LoanStatusNotification($loan));
        return;
    }

    public function destroy(LabLoan $labLoan)
    {
        // Hanya boleh hapus jika status pending atau rejected
        if (!in_array($labLoan->status, ['pending', 'rejected'])) {
            return redirect()->route('admin.handover.index')
                ->with('error', 'Peminjaman yang sudah diproses tidak dapat dihapus.');
        }

        $labLoan->details()->delete();
        $labLoan->delete();

        return redirect()->route('admin.handover.index')
            ->with('success', 'Data peminjaman berhasil dihapus.');
    }
}