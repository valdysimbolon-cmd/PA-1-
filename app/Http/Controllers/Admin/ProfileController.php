<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $profiles = Profile::latest()->get();
        return view('admin.profile.index', compact('profiles'));
    }

    public function create()
    {
        return view('admin.profile.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|unique:profiles,key',
            'name' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $data = $request->all();

        $data['active'] = $request->has('active') ? 1 : 0;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('profiles', 'public');
        }

        Profile::create($data);

        return redirect()->route('profiles.index')->with('success', 'Data berhasil ditambah!');
    }

    public function edit(Profile $profile)
    {
        return view('admin.profile.edit', compact('profile'));
    }

    public function update(Request $request, Profile $profile)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $data = $request->all();

        $data['active'] = $request->has('active') ? 1 : 0;

        if ($request->hasFile('image')) {
            if ($profile->image) {
                Storage::disk('public')->delete($profile->image);
            }
            $data['image'] = $request->file('image')->store('profiles', 'public');
        }

        $profile->update($data);

        return redirect()->route('profiles.index')->with('success', 'Konten Profil berhasil diperbarui!');
    }

    public function destroy(Profile $profile)
    {
        // 1. Cek apakah profil ini punya gambar
        if ($profile->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($profile->image);
        }
        $profile->delete();
        return redirect()->route('profiles.index')
            ->with('success', 'Data profil "' . $profile->name . '" Berhasil dihapus!');
    }
}