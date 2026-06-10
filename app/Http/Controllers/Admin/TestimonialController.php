<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $testimonials = Testimonial::query()
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                ->orWhere('batch', 'like', "%$search%")
                ->orWhere('position', 'like', "%$search%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

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

    public function create()
    {
        return view('admin.testimonial.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'batch' => 'required|integer|min:1900|max:' . date('Y'),
            'position' => 'required',
            'content' => 'required',
            'photo' => 'nullable|image|max:2048',
        ]);

        try {
            DB::beginTransaction();

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

            return back()->with('error', 'Gagal menyimpan testimoni');
        }
    }

    public function update(Request $request, Testimonial $testimonial)
    {
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

            if ($request->hasFile('photo')) {
                $validated['photo'] = $request->file('photo')->store('testimonials', 'public');
            }

            $validated['active'] = $request->boolean('active');

            $testimonial->update($validated);

            if ($request->hasFile('photo') && $oldPhoto) {
                Storage::disk('public')->delete($oldPhoto);
            }

            DB::commit();

            return redirect()
                ->route('testimonials.index')
                ->with('success', 'Testimoni berhasil diupdate');

        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->with('error', 'Gagal update testimoni');
        }
    }

    public function destroy(Testimonial $testimonial)
    {
        try {
            DB::beginTransaction();

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

            return back()->with('error', 'Gagal menghapus testimoni');
        }
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonial.edit', compact('testimonial'));
    }
}