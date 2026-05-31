<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cooperation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; 

class CooperationController extends Controller
{
    public function index()
    {
        $cooperations = Cooperation::latest()->get();
        return view('admin.cooperation.index', compact('cooperations'));
    }

    public function create()
    {
        return view('admin.cooperation.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi Lengkap (Termasuk Deskripsi & Tanggal)
        $request->validate([
            'name'        => 'required|string|max:255',
            'type'        => 'required',
            'logo'        => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date',
            'description' => 'nullable|string', // Pengganti Website URL
        ]);

        $data = $request->all();
        $data['active'] = $request->boolean('active');

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('cooperations', 'public');
        }

        Cooperation::create($data);

        return redirect()->route('cooperations.index')->with('success', 'Mitra baru berhasil ditambahkan!');
    }

    public function edit(Cooperation $cooperation)
    {
        return view('admin.cooperation.edit', compact('cooperation'));
    }

    public function update(Request $request, Cooperation $cooperation)
    {
        // 2. Validasi Update
        $request->validate([
            'name'        => 'required|string|max:255',
            'type'        => 'required',
            'logo'        => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['active'] = $request->boolean('active');

        if ($request->hasFile('logo')) {
            // Hapus logo lama agar tidak jadi sampah di server
            if ($cooperation->logo) {
                Storage::disk('public')->delete($cooperation->logo);
            }
            $data['logo'] = $request->file('logo')->store('cooperations', 'public');
        }

        $cooperation->update($data);

        return redirect()->route('cooperations.index')->with('success', 'Data mitra berhasil diperbarui!');
    }

    public function destroy(Cooperation $cooperation)
    {
        // 3. Hapus file fisik logo
        if ($cooperation->logo) {
            Storage::disk('public')->delete($cooperation->logo);
        }

        $cooperation->delete();

        return redirect()->route('cooperations.index')->with('success', 'Data mitra telah dihapus.');
    }
}