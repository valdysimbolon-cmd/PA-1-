<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cooperation;
use Illuminate\Http\Request;

class CooperationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cooperations = \App\Models\Cooperation::latest()->get();
        return view('admin.cooperation.index', compact('cooperations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.cooperation.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required',
            'logo' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        $data['active'] = $request->boolean('active');

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('cooperations', 'public');
        }

        // Langsung buat tanpa mikirin slug
        Cooperation::create($data);

        return redirect()->route('cooperations.index')->with('success', 'Mitra berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cooperation $cooperation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cooperation $cooperation)
    {
        // Pastikan ada 'return view' ke file yang benar
        return view('admin.cooperation.edit', compact('cooperation'));
    }

    // 2. Fungsi untuk MEMPROSES perubahan data
    public function update(Request $request, Cooperation $cooperation)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required',
            'logo' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        $data['active'] = $request->boolean('active');

        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($cooperation->logo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($cooperation->logo);
            }
            $data['logo'] = $request->file('logo')->store('cooperations', 'public');
        }

        $cooperation->update($data);

        return redirect()->route('cooperations.index')->with('success', 'Data mitra berhasil diperbarui!');
    }

    // 3. Fungsi untuk MENGHAPUS data
    public function destroy(Cooperation $cooperation)
    {
        // Hapus file logo dari storage agar tidak memenuhi server
        if ($cooperation->logo) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($cooperation->logo);
        }

        $cooperation->delete();

        // SANGAT PENTING: Harus ada return redirect agar tidak LAYAR PUTIH
        return redirect()->route('cooperations.index')->with('success', 'Mitra berhasil dihapus!');
    }
}
