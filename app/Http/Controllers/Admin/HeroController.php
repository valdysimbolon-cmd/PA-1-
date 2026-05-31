<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroController extends Controller
{
    public function index() {
        $heroes = Hero::latest()->get();
        return view('admin.hero.index', compact('heroes'));
    }

    public function create() {
        return view('admin.hero.create');
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required',
            'video_url' => 'required|url', // Validasi harus berupa link URL
        ]);

        $data = $request->all();
        $data['active'] = $request->boolean('active');

        // Tidak ada lagi proses upload video yang berat!
        Hero::create($data);

        return redirect()->route('heroes.index')->with('success', 'Banner Berhasil Diperbarui!');
    }

    public function edit(Hero $hero) {
        return view('admin.hero.edit', compact('hero'));
    }

    public function update(Request $request, Hero $hero) {
        $data = $request->all();
        $data['active'] = $request->boolean('active');

        if ($request->hasFile('video_file')) {
            if ($hero->video_file) Storage::disk('public')->delete($hero->video_file);
            $data['video_file'] = $request->file('video_file')->store('heroes/videos', 'public');
        }

        if ($request->hasFile('poster_image')) {
            if ($hero->poster_image) Storage::disk('public')->delete($hero->poster_image);
            $data['poster_image'] = $request->file('poster_image')->store('heroes/posters', 'public');
        }

        $hero->update($data);
        return redirect()->route('heroes.index')->with('success', 'Banner Beranda diperbarui!');
    }

    public function destroy(Hero $hero) {
        if ($hero->video_file) Storage::disk('public')->delete($hero->video_file);
        if ($hero->poster_image) Storage::disk('public')->delete($hero->poster_image);
        $hero->delete();
        return back()->with('success', 'Banner dihapus.');
    }
}