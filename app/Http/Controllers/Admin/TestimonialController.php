<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // WAJIB UNTUK HAPUS FILE

class TestimonialController extends Controller
{
    public function index() {
        $testimonials = Testimonial::latest()->get();
        return view('admin.testimonial.index', compact('testimonials'));
    }

    public function create() {
        return view('admin.testimonial.create');
    }

public function store(Request $request) {
    // ... validasi ...
    $data = $request->all();
    $data['active'] = $request->has('active') ? 1 : 0;
    $data['created_by'] = auth()->id(); // WAJIB ADA

    if ($request->hasFile('photo')) {
        $data['photo'] = $request->file('photo')->store('testimonials', 'public');
    }
    Testimonial::create($data);
    return redirect()->route('testimonials.index');
}

    /**
     * Menampilkan form edit (LOKER PERBAIKAN)
     */
    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonial.edit', compact('testimonial'));
    }

    /**
     * Memperbarui data (PROSES RENOVASI)
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'batch' => 'required|integer',
            'position' => 'required|string',
            'content' => 'required',
            'photo' => 'nullable|image|max:2048'
        ]);

        $data = $request->all();
        $data['active'] = $request->boolean('active');

        if ($request->hasFile('photo')) {
            // 1. Hapus Foto LAMA agar server tidak penuh sampah
            if ($testimonial->photo) {
                Storage::disk('public')->delete($testimonial->photo);
            }
            // 2. Simpan Foto BARU
            $data['photo'] = $request->file('photo')->store('testimonials', 'public');
        }

        $testimonial->update($data);
        return redirect()->route('testimonials.index')->with('success', 'Data testimoni berhasil diperbarui!');
    }

    /**
     * Menghapus data (PEMBERSIHAN TOTAL)
     */
    public function destroy(Testimonial $testimonial)
    {
        // 1. Hapus file foto fisiknya dulu
        if ($testimonial->photo) {
            Storage::disk('public')->delete($testimonial->photo);
        }

        // 2. Hapus datanya di database
        $testimonial->delete();

        return redirect()->route('testimonials.index')->with('success', 'Testimoni telah dihapus selamanya.');
    }
}