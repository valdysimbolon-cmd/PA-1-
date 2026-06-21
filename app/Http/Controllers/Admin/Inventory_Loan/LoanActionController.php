<?php

namespace App\Http\Controllers\Admin\inventory_loan;

use App\Http\Controllers\Controller;
use App\Models\LabLoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Mapping kolom lab_loan:
 *   return_date   = tanggal barang KELUAR ke mahasiswa (diisi saat handover)
 *   returned_date = tanggal barang KEMBALI ke lab      (diisi saat return)
 */
class LoanActionController extends Controller
{
    // ─────────────────────────────────────────
    // HANDOVER — Barang keluar ke mahasiswa
    // ─────────────────────────────────────────

    public function indexHandover()
    {
        $loans = LabLoan::with(['details.inventory', 'lab'])
            ->where('status', 'approved')
            ->whereNull('return_date')
            ->latest()
            ->paginate(15);

        return view('admin.lab_loan.handover', compact('loans'));
    }

    public function confirmHandover(Request $request, LabLoan $labLoan)
    {
        if ($labLoan->status !== 'approved') {
            return back()->with('error', 'Hanya peminjaman berstatus "Disetujui" yang bisa dikonfirmasi penyerahan.');
        }

        if ($labLoan->return_date) {
            return back()->with('error', 'Barang ini sudah pernah dikonfirmasi keluar sebelumnya.');
        }

        DB::beginTransaction();
        try {
            // Reload fresh dari DB agar tidak pakai cache
            $labLoan->load('details.inventory');

            foreach ($labLoan->details as $detail) {
                if (!$detail->inventory) {
                    Log::warning("Handover skip: inventory null", [
                        'detail_id'    => $detail->id,
                        'inventory_id' => $detail->inventory_id,
                    ]);
                    continue;
                }

                $before = $detail->inventory->quantity_available;
                $detail->inventory->decreaseStock($detail->quantity);
                $after = $detail->inventory->fresh()->quantity_available;

                Log::info("Handover stok berkurang", [
                    'item'   => $detail->inventory->item_name,
                    'before' => $before,
                    'reduce' => $detail->quantity,
                    'after'  => $after,
                ]);
            }

            $labLoan->update([
                'return_date' => now()->toDateString(),
                'admin_notes' => $request->admin_notes ?? $labLoan->admin_notes,
            ]);

            DB::commit();

            return back()->with('success',
                "Barang keluar untuk resi {$labLoan->receipt_number} berhasil dikonfirmasi. Stok sudah dikurangi."
            );

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Handover gagal", ['error' => $e->getMessage(), 'loan_id' => $labLoan->id]);
            return back()->with('error', 'Gagal konfirmasi handover: ' . $e->getMessage());
        }
    }

    // ─────────────────────────────────────────
    // RETURN — Barang kembali ke lab
    // ─────────────────────────────────────────

    public function indexReturn()
    {
        $loans = LabLoan::with(['details.inventory', 'lab'])
            ->where('status', 'approved')
            ->whereNotNull('return_date')
            ->whereNull('returned_date')
            ->latest()
            ->paginate(15);

        return view('admin.lab_loan.return', compact('loans'));
    }

    public function confirmReturn(Request $request, LabLoan $labLoan)
    {
        if ($labLoan->status !== 'approved') {
            return back()->with('error', 'Peminjaman ini tidak dalam status yang bisa dikembalikan.');
        }

        if (!$labLoan->return_date) {
            return back()->with('error', 'Barang belum dikonfirmasi keluar. Lakukan handover terlebih dahulu.');
        }

        if ($labLoan->returned_date) {
            return back()->with('error', 'Barang ini sudah pernah dikonfirmasi kembali sebelumnya.');
        }

        $request->validate([
            'condition_notes' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();
        try {
            // Reload fresh dari DB agar tidak pakai cache
            $labLoan->load('details.inventory');

            foreach ($labLoan->details as $detail) {
                if (!$detail->inventory) {
                    Log::warning("Return skip: inventory null", [
                        'detail_id'    => $detail->id,
                        'inventory_id' => $detail->inventory_id,
                    ]);
                    continue;
                }

                $before = $detail->inventory->quantity_available;
                $detail->inventory->increaseStock($detail->quantity);
                $after = $detail->inventory->fresh()->quantity_available;

                Log::info("Return stok kembali", [
                    'item'   => $detail->inventory->item_name,
                    'before' => $before,
                    'add'    => $detail->quantity,
                    'after'  => $after,
                ]);
            }

            $labLoan->update([
                'status'        => 'returned',
                'returned_date' => now()->toDateString(),
                'admin_notes'   => $request->condition_notes ?? $labLoan->admin_notes,
            ]);

            DB::commit();

            return back()->with('success',
                "Pengembalian resi {$labLoan->receipt_number} dikonfirmasi. Stok sudah dipulihkan."
            );

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Return gagal", ['error' => $e->getMessage(), 'loan_id' => $labLoan->id]);
            return back()->with('error', 'Gagal konfirmasi pengembalian: ' . $e->getMessage());
        }
    }

    // ─────────────────────────────────────────
    // SCAN RESI
    // ─────────────────────────────────────────

    public function scanReceipt(Request $request)
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

        return view('admin.loan-action.scan', compact('loan'));
    }
}