<?php

namespace App\Http\Controllers\Admin\Facility;

use Exception;
use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Class FacilityController
 *
 * Mengelola data fasilitas (sarana dan prasarana) kampus.
 * Mendukung operasi CRUD, filter berdasarkan tipe dan pencarian,
 * serta upload gambar fasilitas.
 * Akses: Super Admin & Admin Lab.
 */
class FacilityController extends Controller
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
     * Menampilkan daftar fasilitas dengan filter pencarian dan tipe.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $this->authorizeRole(['super_admin', 'admin_lab']);

        $query = Facility::query();

        // Filter pencarian (nama / lokasi)
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('location', 'like', '%' . $request->search . '%');
            });
        }

        // Filter tipe
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $facilities = $query->latest()->paginate(10)->withQueryString();

        // Kirim daftar tipe unik untuk dropdown filter
        $types = Facility::select('type')->distinct()->pluck('type');

        return view('admin.facility.index', compact('facilities', 'types'));
    }

    /**
     * Menampilkan form tambah fasilitas.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorizeRole(['super_admin', 'admin_lab']);

        return view('admin.facility.create');
    }

    /**
     * Menyimpan data fasilitas baru ke database.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->authorizeRole(['super_admin', 'admin_lab']);

        // Validasi input
        $request->validate([
            'name'        => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'capacity'    => 'nullable|integer|min:0',
            'location'    => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();

        try {
            // Siapkan data utama
            $data = [
                'name'        => $request->name,
                'type'        => $request->type,
                'capacity'    => $request->capacity,
                'location'    => $request->location,
                'description' => $request->description,
                'active'      => $request->boolean('active'),
                'created_by'  => Auth::id(),
            ];

            // Upload gambar jika ada
            if ($request->hasFile('image')) {
                $data['image'] = $request
                    ->file('image')
                    ->store('facilities', 'public');
            }

            Facility::create($data);

            DB::commit();

            return redirect()
                ->route('facilities.index')
                ->with('success', 'Fasilitas berhasil ditambahkan.');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Gagal menyimpan fasilitas', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan fasilitas.');
        }
    }

    /**
     * Menampilkan form edit fasilitas.
     *
     * @param Facility $facility
     * @return \Illuminate\View\View
     */
    public function edit(Facility $facility)
    {
        $this->authorizeRole(['super_admin', 'admin_lab']);

        return view('admin.facility.edit', compact('facility'));
    }

    /**
     * Memperbarui data fasilitas yang sudah ada.
     *
     * @param Request $request
     * @param Facility $facility
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Facility $facility)
    {
        $this->authorizeRole(['super_admin', 'admin_lab']);

        // Validasi input
        $request->validate([
            'name'        => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'capacity'    => 'nullable|integer|min:0',
            'location'    => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();

        try {
            // Siapkan data update
            $data = [
                'name'        => $request->name,
                'type'        => $request->type,
                'capacity'    => $request->capacity,
                'location'    => $request->location,
                'description' => $request->description,
                'active'      => $request->boolean('active'),
                'updated_by'  => Auth::id(),
            ];

            // Proses upload gambar baru (hapus gambar lama jika ada)
            if ($request->hasFile('image')) {
                if ($facility->image && Storage::disk('public')->exists($facility->image)) {
                    Storage::disk('public')->delete($facility->image);
                }

                $data['image'] = $request
                    ->file('image')
                    ->store('facilities', 'public');
            }

            $facility->update($data);

            DB::commit();

            return redirect()
                ->route('facilities.index')
                ->with('success', 'Data fasilitas berhasil diperbarui.');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Gagal memperbarui fasilitas', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui fasilitas.');
        }
    }

    /**
     * Menghapus fasilitas beserta file gambar dari storage.
     *
     * @param Facility $facility
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Facility $facility)
    {
        $this->authorizeRole(['super_admin', 'admin_lab']);

        DB::beginTransaction();

        try {
            // Hapus file gambar jika ada
            if ($facility->image && Storage::disk('public')->exists($facility->image)) {
                Storage::disk('public')->delete($facility->image);
            }

            $facility->delete();

            DB::commit();

            return redirect()
                ->route('facilities.index')
                ->with('success', 'Fasilitas berhasil dihapus.');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Gagal menghapus fasilitas', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            return redirect()
                ->route('facilities.index')
                ->with('error', 'Fasilitas gagal dihapus.');
        }
    }
}