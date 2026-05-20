<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Curriculum;
use Illuminate\Http\Request;

class CurriculumController extends Controller
{
    public function index() {
        // Menggunakan relasi creator (dari Trait Blameable)
        $curriculums = Curriculum::with('creator')->latest()->get();
        return view('admin.curriculum.index', compact('curriculums'));
    }

    // INI YANG TADI HILANG:
    public function create() {
        return view('admin.curriculum.create');
    }

    public function store(Request $request) {
        $request->validate(['name' => 'required|string|max:255']);
        
        $data = $request->all();
        $data['active'] = $request->boolean('active', true);
        
        Curriculum::create($data);
        return redirect()->route('curriculums.index')->with('success', 'Kurikulum berhasil dibuat!');
    }

    public function show(Curriculum $curriculum) {
        $curriculum->load('subjects');
        return view('admin.curriculum.show', compact('curriculum'));
    }

    public function edit(Curriculum $curriculum) {
        return view('admin.curriculum.edit', compact('curriculum'));
    }

    public function update(Request $request, Curriculum $curriculum) {
        $request->validate(['name' => 'required|string|max:255']);
        
        $data = $request->all();
        $data['active'] = $request->boolean('active');
        
        $curriculum->update($data);
        return redirect()->route('curriculums.index')->with('success', 'Kurikulum diperbarui!');
    }

    public function destroy(Curriculum $curriculum) {
        $curriculum->delete();
        return redirect()->route('curriculums.index')->with('success', 'Kurikulum berhasil dihapus!');
    }
}