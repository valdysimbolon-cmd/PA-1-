<?php

namespace App\Http\Controllers\Admin\News_Information;

use App\Http\Controllers\Controller;
use App\Models\Cooperation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Class CooperationController
 *
 * Mengelola data kerja sama dengan mitra (industri, akademik, pemerintah).
 * Mendukung operasi CRUD, unggah logo, dan filter berdasarkan tipe.
 */
class CooperationController extends Controller
{

    private function authorizeRole(array $roles): void
    {
        if (!in_array(auth()->user()->role, $roles)) {
            abort(403, 'Akses ditolak. Hanya Super Admin yang diizinkan.');
        }
    }

    /**
     * Menampilkan daftar kerja sama dengan fitur pencarian dan filter tipe.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Cooperation::query();

        // Filter pencarian berdasarkan nama mitra
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan tipe (Industri, Akademik, Pemerintah)
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $cooperations = $query->latest()->paginate(10)->withQueryString();

        return view('admin.cooperation.index', compact('cooperations'));
    }

    /**
     * Menampilkan form tambah kerja sama.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.cooperation.create');
    }

    /**
     * Menyimpan data kerja sama baru ke database.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required',
            'type' => ['required', Rule::in(['Industri','Akademik','Pemerintah'])],
            'logo' => 'nullable|image|max:2048',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'description' => 'nullable|string',
            'active' => 'nullable|boolean',
        ]);

        try {
            DB::beginTransaction();

            // Upload logo jika ada
            if ($request->hasFile('logo')) {
                $validated['logo'] = $request->file('logo')->store('cooperations', 'public');
            }

            $validated['active'] = $request->boolean('active');

            Cooperation::create($validated);

            DB::commit();

            return redirect()
                ->route('cooperations.index')
                ->with('success', 'Kerja sama berhasil ditambahkan');

        } catch (\Throwable $e) {
            DB::rollBack();

            // Catat error untuk debugging
            Log::error('Gagal store cooperation: ' . $e->getMessage());

            return back()->with('error', 'Gagal menyimpan data');
        }
    }

    /**
     * Memperbarui data kerja sama yang sudah ada.
     *
     * @param Request $request
     * @param Cooperation $cooperation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Cooperation $cooperation)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required',
            'type' => ['required', Rule::in(['Industri','Akademik','Pemerintah'])],
            'logo' => 'nullable|image|max:2048',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $oldLogo = $cooperation->logo;

            // Upload logo baru jika ada
            if ($request->hasFile('logo')) {
                $validated['logo'] = $request->file('logo')->store('cooperations', 'public');
            }

            $validated['active'] = $request->boolean('active');

            $cooperation->update($validated);

            // Hapus logo lama jika diganti
            if ($request->hasFile('logo') && $oldLogo) {
                Storage::disk('public')->delete($oldLogo);
            }

            DB::commit();

            return redirect()
                ->route('cooperations.index')
                ->with('success', 'Kerja sama berhasil diupdate');

        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Gagal update cooperation: ' . $e->getMessage());

            return back()->with('error', 'Gagal update data');
        }
    }

    /**
     * Menghapus data kerja sama beserta file logo dari storage.
     *
     * @param Cooperation $cooperation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Cooperation $cooperation)
    {
        try {
            DB::beginTransaction();

            // Hapus logo jika ada
            if ($cooperation->logo) {
                Storage::disk('public')->delete($cooperation->logo);
            }

            $cooperation->delete();

            DB::commit();

            return redirect()
                ->route('cooperations.index')
                ->with('success', 'Kerja sama berhasil dihapus');

        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Gagal destroy cooperation: ' . $e->getMessage());

            return back()->with('error', 'Gagal menghapus data');
        }
    }

    /**
     * Menampilkan form edit kerja sama.
     *
     * @param Cooperation $cooperation
     * @return \Illuminate\View\View
     */
    public function edit(Cooperation $cooperation)
    {
        return view('admin.cooperation.edit', compact('cooperation'));
    }
}