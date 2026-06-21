<?php

namespace App\Http\Controllers\Admin\inventory_loan;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Lab;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Class InventoryController
 *
 * Mengelola data inventaris alat/bahan laboratorium.
 * Mendukung operasi CRUD, filter berdasarkan lab, kategori, status,
 * serta penanganan stok dan field khusus untuk bahan kimia.
 * Akses: Super Admin & Admin Lab.
 */
class InventoryController extends Controller
{
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
     * Menampilkan daftar inventaris dengan filter pencarian, lab, kategori, dan status.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $this->authorizeRole(['super_admin', 'admin_lab']);

        $query = Inventory::with('lab');

        // Filter pencarian berdasarkan nama atau kode barang
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('item_name', 'like', '%' . $request->search . '%')
                    ->orWhere('item_code', 'like', '%' . $request->search . '%');
            });
        }

        // Filter berdasarkan laboratorium
        if ($request->filled('lab_id')) {
            $query->where('lab_id', $request->lab_id);
        }

        // Filter berdasarkan kategori (Equipment, Material, Instrument)
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter berdasarkan status aktif
        if ($request->filled('active')) {
            $query->where('active', $request->active);
        }

        $inventories = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // Ambil daftar lab aktif untuk dropdown filter dan form
        $labs = Lab::where('active', true)
            ->orderBy('name')
            ->get();

        return view('admin.inventory.index', compact('inventories', 'labs'));
    }

    /**
     * Menampilkan form tambah inventaris.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorizeRole(['super_admin', 'admin_lab']);

        $labs = Lab::where('active', true)
            ->orderBy('name')
            ->get();

        return view('admin.inventory.create', compact('labs'));
    }

    /**
     * Menyimpan data inventaris baru ke database.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->authorizeRole(['super_admin', 'admin_lab']);

        $validated = $request->validate([
            'lab_id'            => 'nullable|exists:labs,id',
            'item_code'         => 'required|string|max:50',
            'item_name'         => 'required|string|max:255',
            'category'          => 'required|in:Equipment,Material,Instrument',
            'unit'              => 'required|string|max:50',
            'quantity'          => 'required|integer|min:0',
            'price'             => 'nullable|numeric|min:0',
            'gross_weight'      => 'nullable|string|max:100',
            'net_weight'        => 'nullable|string|max:100',
            'spesification'     => 'nullable|string',
            'description'       => 'nullable|string',
            'chemical_formula'  => 'nullable|string|max:255',
            'storage'           => 'nullable|string|max:255',
            'condition'         => 'nullable|string|max:100',
            'expiry_date'       => 'nullable|date',
            'cupboard_location' => 'nullable|string|max:255',
            'year'              => 'nullable|integer|min:1900|max:' . date('Y'),
            'image'             => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'active'            => 'nullable|boolean',
        ]);

        DB::beginTransaction();

        try {
            // Set nilai default: stok tersedia = total stok, aktif = true jika tidak diset
            $validated['quantity_available'] = $validated['quantity'];
            $validated['active'] = $request->boolean('active', true);
            $validated['created_by'] = Auth::id();
            $validated['updated_by'] = Auth::id();

            // Jika kategori bukan Material (bahan kimia), kosongkan field khusus bahan kimia
            if ($validated['category'] !== 'Material') {
                $validated['chemical_formula'] = null;
                $validated['expiry_date'] = null;
                $validated['gross_weight'] = null;
                $validated['net_weight'] = null;
                $validated['storage'] = null;
            }

            // Upload gambar jika ada
            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')
                    ->store('inventory', 'public');
            }

            Inventory::create($validated);

            DB::commit();

            return redirect()
                ->route('inventories.index')
                ->with('success', 'Item inventaris berhasil ditambahkan.');
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Gagal simpan inventory', [
                'message' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data inventaris.');
        }
    }

    /**
     * Menampilkan form edit inventaris.
     *
     * @param Inventory $inventory
     * @return \Illuminate\View\View
     */
    public function edit(Inventory $inventory)
    {
        $this->authorizeRole(['super_admin', 'admin_lab']);

        $labs = Lab::where('active', true)
            ->orderBy('name')
            ->get();

        return view('admin.inventory.edit', compact('inventory', 'labs'));
    }

    /**
     * Memperbarui data inventaris yang sudah ada.
     * Menangani perubahan stok total dan penyesuaian stok tersedia.
     *
     * @param Request $request
     * @param Inventory $inventory
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Inventory $inventory)
    {
        $this->authorizeRole(['super_admin', 'admin_lab']);

        $validated = $request->validate([
            'lab_id'           => 'nullable|exists:labs,id',
            'item_code'         => 'required|string|max:50',
            'item_name'         => 'required|string|max:255',
            'category'          => 'required|in:Equipment,Material,Instrument',
            'unit'              => 'required|string|max:50',
            'quantity'          => 'required|integer|min:0',
            'price'             => 'nullable|numeric|min:0',
            'gross_weight'      => 'nullable|string|max:100',
            'net_weight'        => 'nullable|string|max:100',
            'spesification'     => 'nullable|string',
            'description'       => 'nullable|string',
            'chemical_formula'  => 'nullable|string|max:255',
            'storage'           => 'nullable|string|max:255',
            'condition'         => 'nullable|string|max:100',
            'expiry_date'       => 'nullable|date',
            'cupboard_location' => 'nullable|string|max:255',
            'year'              => 'nullable|integer|min:1900|max:' . date('Y'),
            'image'             => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'active'            => 'nullable|boolean',
        ]);

        DB::beginTransaction();

        try {
            /*
             * Jika stok total berubah, sesuaikan stok tersedia dengan selisih.
             * quantity_available = quantity_available_lama + (quantity_baru - quantity_lama)
             * Minimal 0 untuk mencegah stok negatif.
             */
            $selisihStok = $validated['quantity'] - $inventory->quantity;

            $validated['quantity_available'] = max(
                0,
                $inventory->quantity_available + $selisihStok
            );

            $validated['active'] = $request->boolean('active');
            $validated['updated_by'] = Auth::id();

            // Jika bukan bahan kimia, hapus data khusus bahan kimia
            if ($validated['category'] !== 'Material') {
                $validated['chemical_formula'] = null;
                $validated['expiry_date'] = null;
                $validated['gross_weight'] = null;
                $validated['net_weight'] = null;
                $validated['storage'] = null;
            }

            // Upload gambar baru (hapus gambar lama jika ada)
            if ($request->hasFile('image')) {
                if ($inventory->image) {
                    Storage::disk('public')->delete($inventory->image);
                }

                $validated['image'] = $request->file('image')
                    ->store('inventory', 'public');
            }

            $inventory->update($validated);

            DB::commit();

            return redirect()
                ->route('inventories.index')
                ->with('success', 'Data inventaris berhasil diperbarui.');
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Gagal update inventory', [
                'message' => $e->getMessage(),
                'inventory_id' => $inventory->id,
                'user_id' => Auth::id(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data inventaris.');
        }
    }

    /**
     * Menghapus inventaris.
     * Mencegah penghapusan jika item sedang dalam peminjaman aktif (pending/approved).
     *
     * @param Inventory $inventory
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Inventory $inventory)
    {
        $this->authorizeRole(['super_admin', 'admin_lab']);

        // Cek apakah ada peminjaman aktif yang menggunakan item ini
        $hasActiveLoan = $inventory->loanDetails()
            ->whereHas('labLoan', function ($query) {
                $query->whereIn('status', ['pending', 'approved']);
            })
            ->exists();

        if ($hasActiveLoan) {
            return back()->with(
                'error',
                'Item tidak dapat dihapus karena sedang digunakan dalam proses peminjaman.'
            );
        }

        DB::beginTransaction();

        try {
            // Hapus gambar jika ada
            if ($inventory->image) {
                Storage::disk('public')->delete($inventory->image);
            }

            $inventory->delete();

            DB::commit();

            return redirect()
                ->route('inventories.index')
                ->with('success', 'Item inventaris berhasil dihapus.');
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Gagal hapus inventory', [
                'message' => $e->getMessage(),
                'inventory_id' => $inventory->id,
                'user_id' => Auth::id(),
            ]);

            return back()->with('error', 'Gagal menghapus data inventaris.');
        }
    }

    /**
     * Mengaktifkan/menonaktifkan status inventaris (toggle).
     *
     * @param Inventory $inventory
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleStatus(Inventory $inventory)
    {
        $this->authorizeRole(['super_admin', 'admin_lab']);

        $inventory->update([
            'active' => ! $inventory->active,
            'updated_by' => Auth::id(),
        ]);

        return back()->with('success', 'Status inventaris berhasil diubah.');
    }
}