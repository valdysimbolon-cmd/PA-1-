<?php

namespace App\Http\Controllers\Admin\News_Information;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Class TestimonialController
 *
 * Mengelola data testimoni alumni/mahasiswa.
 * Mendukung CRUD, upload foto, filter pencarian, dan statistik status.
 */
class TestimonialController extends Controller
{

    private function authorizeRole(array $roles): void
    {
        if (!in_array(auth()->user()->role, $roles)) {
            abort(403, 'Akses ditolak. Hanya Super Admin yang diizinkan.');
        }
    }
    /**
     * Menampilkan daftar testimoni dengan pencarian dan statistik.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $search = $request->search;

        // Query dengan filter pencarian (nama, batch, posisi)
        $testimonials = Testimonial::query()
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                ->orWhere('batch', 'like', "%$search%")
                ->orWhere('position', 'like', "%$search%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // Statistik untuk dashboard
        $totalTestimonials = Testimonial::count();
        $activeTestimonials = Testimonial::where('active', true)->count();
        $inactiveTestimonials = Testimonial::where('active', false)->count();

        return view('admin.testimonial.index', compact(
            'testimonials',
            'search',
            'totalTestimonials',
            'activeTestimonials',
            'inactiveTestimonials'
        ));
    }

    /**
     * Menampilkan form tambah testimoni.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.testimonial.create');
    }

    /**
     * Menyimpan data testimoni baru.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required',
            'batch' => 'required|integer|min:1900|max:' . date('Y'),
            'position' => 'required',
            'content' => 'required',
            'photo' => 'nullable|image|max:2048',
        ]);

        try {
            DB::beginTransaction();

            // Upload foto jika ada
            if ($request->hasFile('photo')) {
                $validated['photo'] = $request->file('photo')->store('testimonials', 'public');
            }

            $validated['active'] = $request->boolean('active');

            Testimonial::create($validated);

            DB::commit();

            return redirect()
                ->route('testimonials.index')
                ->with('success', 'Testimoni berhasil ditambahkan');

        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Gagal store testimonial: ' . $e->getMessage());

            return back()->with('error', 'Gagal menyimpan testimoni');
        }
    }

    /**
     * Memperbarui data testimoni yang sudah ada.
     *
     * @param Request $request
     * @param Testimonial $testimonial
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required',
            'batch' => 'required|integer|min:1900|max:' . date('Y'),
            'position' => 'required',
            'content' => 'required',
            'photo' => 'nullable|image|max:2048',
        ]);

        try {
            DB::beginTransaction();

            $oldPhoto = $testimonial->photo;

            // Upload foto baru jika ada
            if ($request->hasFile('photo')) {
                $validated['photo'] = $request->file('photo')->store('testimonials', 'public');
            }

            $validated['active'] = $request->boolean('active');

            $testimonial->update($validated);

            // Hapus foto lama jika diganti
            if ($request->hasFile('photo') && $oldPhoto) {
                Storage::disk('public')->delete($oldPhoto);
            }

            DB::commit();

            return redirect()
                ->route('testimonials.index')
                ->with('success', 'Testimoni berhasil diupdate');

        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Gagal update testimonial: ' . $e->getMessage());

            return back()->with('error', 'Gagal update testimoni');
        }
    }

    /**
     * Menghapus testimoni beserta file foto dari storage.
     *
     * @param Testimonial $testimonial
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Testimonial $testimonial)
    {
        try {
            DB::beginTransaction();

            // Hapus foto jika ada
            if ($testimonial->photo) {
                Storage::disk('public')->delete($testimonial->photo);
            }

            $testimonial->delete();

            DB::commit();

            return redirect()
                ->route('testimonials.index')
                ->with('success', 'Testimoni berhasil dihapus');

        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Gagal destroy testimonial: ' . $e->getMessage());

            return back()->with('error', 'Gagal menghapus testimoni');
        }
    }

    /**
     * Menampilkan form edit testimoni.
     *
     * @param Testimonial $testimonial
     * @return \Illuminate\View\View
     */
    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonial.edit', compact('testimonial'));
    }
}