<?php

namespace App\Http\Controllers\Admin\Facility;

use App\Http\Controllers\Controller;
use App\Models\Lab;
use App\Models\Lecturer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

/**
 * Class LabController
 *
 * Mengelola data laboratorium (unit lab) beserta inventaris alat di dalamnya.
 * Mendukung CRUD laboratorium, manajemen kepala lab dan staff,
 * serta operasi pada katalog alat (inventaris) secara bersamaan.
 * Akses: Super Admin & Admin Lab.
 */
class LabController extends Controller
{
    /**
     * Memeriksa apakah user memiliki role yang diizinkan.
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
     * Menampilkan daftar laboratorium dengan filter pencarian dan kategori.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request)
    {
        $this->authorizeRole(['super_admin', 'admin_lab']);

        $query = Lab::with('head');
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        $labs = $query->latest()->paginate(10)->withQueryString();
        return view('admin.lab.index', compact('labs'));
    }

    /**
     * Menampilkan form tambah laboratorium dengan pilihan dosen dan staff.
     *
     * @return View
     */
    public function create(): View
    {
        $this->authorizeRole(['super_admin', 'admin_lab']);

        $lecturers = Lecturer::all();
        $staffs    = User::all();
        return view('admin.lab.create', compact('lecturers', 'staffs'));
    }

    /**
     * Menampilkan form edit laboratorium beserta daftar inventaris yang ada.
     *
     * @param Lab $lab
     * @return View
     */
    public function edit(Lab $lab): View
    {
        $this->authorizeRole(['super_admin', 'admin_lab']);

        // Muat relasi inventaris untuk ditampilkan di form
        $lab->load('inventories');
        $lecturers = Lecturer::all();
        $staffs    = User::all();
        return view('admin.lab.edit', compact('lab', 'lecturers', 'staffs'));
    }

    // -------------------------------------------------------------------------
    // STORE — Menyimpan Data Baru
    // -------------------------------------------------------------------------

    /**
     * Menyimpan laboratorium baru beserta inventaris alat yang dikirimkan.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorizeRole(['super_admin', 'admin_lab']);

        $request->validate([
            'name'            => 'required|string|max:255',
            'category'        => 'required|in:Praktikum,Riset,Umum',
            'location'        => 'nullable|string|max:255',
            'head_of_lab_id'  => 'nullable|exists:lecturers,id',
            'staff_id'        => 'nullable|exists:users,id',
            'description'     => 'nullable|string',
            'active'          => 'nullable|boolean',
            'image'           => 'nullable|image|mimes:jpeg,png,webp|max:2048',
            'inventory_name'         => 'nullable|array',
            'inventory_name.*'       => 'nullable|string|max:255',
            'inventory_image.*'      => 'nullable|image|mimes:jpeg,png,webp|max:2048',
            'inventory_description.*'=> 'nullable|string|max:500',
        ]);

        $imagePath = null;

        try {
            // Upload banner lab
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('labs', 'public');
                if (! $imagePath) throw new \RuntimeException('Gagal upload banner lab.');
            }

            DB::transaction(function () use ($request, $imagePath) {
                // Simpan data lab
                $lab = Lab::create([
                    'name'           => $request->name,
                    'category'       => $request->category,
                    'location'       => $request->location,
                    'head_of_lab_id' => $request->head_of_lab_id,
                    'staff_id'       => $request->staff_id,
                    'description'    => $request->description,
                    'active'         => $request->boolean('active', true),
                    'image'          => $imagePath,
                    'created_by'     => auth()->id(),
                    'updated_by'     => auth()->id(),
                ]);

                // Simpan inventaris alat jika ada yang diisi
                $inventoryNames = $request->input('inventory_name', []);

                foreach ($inventoryNames as $i => $name) {
                    // Lewati baris yang nama alatnya kosong
                    if (empty(trim($name ?? ''))) continue;

                    $inventoryImagePath = null;

                    // Upload foto alat per index
                    if ($request->hasFile("inventory_image.$i")) {
                        $inventoryImagePath = $request->file("inventory_image.$i")
                            ->store('inventories', 'public');
                    }

                    $lab->inventories()->create([
                        'name'               => $name,
                        'code'               => null,   // diisi nanti via import Excel
                        'quantity'           => 1,
                        'quantity_available' => 1,
                        'condition'          => 'Baik',
                        'image'              => $inventoryImagePath,
                        'description'        => $request->input("inventory_description.$i"),
                        'active'             => true,
                        'created_by'         => auth()->id(),
                    ]);
                }
            });

            return redirect()
                ->route('labs.index')
                ->with('success', 'Unit Lab berhasil dibuat!');

        } catch (\Throwable $e) {
            // Rollback banner jika DB gagal
            if ($imagePath) Storage::disk('public')->delete($imagePath);

            Log::error('Lab store failed', [
                'user_id' => auth()->id(),
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    // -------------------------------------------------------------------------
    // UPDATE — Memperbarui Data
    // -------------------------------------------------------------------------

    /**
     * Memperbarui data laboratorium dan sinkronisasi inventaris alat.
     * Inventaris lama yang tidak memiliki relasi peminjaman akan dihapus,
     * lalu dibuat ulang berdasarkan input dari form.
     *
     * @param Request $request
     * @param Lab $lab
     * @return RedirectResponse
     */
    public function update(Request $request, Lab $lab): RedirectResponse
    {
        $this->authorizeRole(['super_admin', 'admin_lab']);

        $request->validate([
            'name'           => 'required|string|max:255',
            'category'       => 'required|in:Praktikum,Riset,Umum',
            'location'       => 'nullable|string|max:255',
            'head_of_lab_id' => 'nullable|exists:lecturers,id',
            'staff_id'       => 'nullable|exists:users,id',
            'description'    => 'nullable|string',
            'active'         => 'nullable|boolean',
            'image'          => 'nullable|image|mimes:jpeg,png,webp|max:2048',
            'inventory_name'      => 'nullable|array',
        ]);

        $newImagePath = null;
        $oldImagePath = $lab->image;

        try {
            // Upload banner baru jika ada
            if ($request->hasFile('image')) {
                $newImagePath = $request->file('image')->store('labs', 'public');
            }

            DB::transaction(function () use ($request, $newImagePath, $lab) {
                // 1. Update Data Lab Utama
                $lab->update([
                    'name'           => $request->name,
                    'category'       => $request->category,
                    'location'       => $request->location,
                    'head_of_lab_id' => $request->head_of_lab_id,
                    'staff_id'       => $request->staff_id,
                    'description'    => $request->description,
                    'active'         => $request->boolean('active'),
                    'image'          => $newImagePath ?? $lab->image,
                    'updated_by'     => auth()->id(),
                ]);

                // 2. Sinkronisasi Data Alat (inventories)
                // Hapus alat lama yang tidak memiliki relasi peminjaman
                $lab->inventories()
                    ->whereDoesntHave('loanDetails')
                    ->delete();

                // Simpan ulang semua alat dari form
                $inventoryNames = $request->input('inventory_name', []);
                foreach ($inventoryNames as $i => $name) {
                    if (empty(trim($name ?? ''))) continue;

                    $inventoryImagePath = null;
                    // Upload gambar alat jika ada
                    if ($request->hasFile("inventory_image.$i")) {
                        $inventoryImagePath = $request->file("inventory_image.$i")->store('inventories', 'public');
                    }

                    $lab->inventories()->create([
                        'name'        => $name,
                        'quantity'    => 1,
                        'condition'   => 'Baik',
                        'image'       => $inventoryImagePath,
                        'description' => $request->input("inventory_description.$i"),
                        'created_by'  => auth()->id(),
                    ]);
                }
            });

            // Hapus banner lama jika ada banner baru
            if ($newImagePath && $oldImagePath) {
                Storage::disk('public')->delete($oldImagePath);
            }

            return redirect()->route('labs.index')->with('success', 'Unit Lab dan Katalog Alat berhasil diperbarui!');

        } catch (\Throwable $e) {
            // Rollback banner baru jika gagal
            if ($newImagePath) Storage::disk('public')->delete($newImagePath);
            Log::error('Lab update failed: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal memperbarui data.');
        }
    }

    // -------------------------------------------------------------------------
    // DESTROY — Menghapus Data
    // -------------------------------------------------------------------------

    /**
     * Menghapus laboratorium beserta seluruh data inventaris terkait (cascade).
     *
     * @param Lab $lab
     * @return RedirectResponse
     */
    public function destroy(Lab $lab): RedirectResponse
    {
        $this->authorizeRole(['super_admin', 'admin_lab']);

        $imagePath = $lab->image;

        try {
            DB::transaction(function () use ($lab) {
                $lab->delete();
            });

            // Hapus banner dari storage
            if ($imagePath) Storage::disk('public')->delete($imagePath);

            return back()->with('success', 'Unit Lab berhasil dihapus!');

        } catch (\Throwable $e) {
            Log::error('Lab destroy failed', [
                'user_id' => auth()->id(),
                'lab_id'  => $lab->id,
                'error'   => $e->getMessage(),
            ]);

            return back()->with('error', 'Gagal menghapus lab.');
        }
    }
}