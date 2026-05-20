<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Curriculum;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index() {
        $subjects = Subject::with('curriculum')->orderBy('semester', 'asc')->get();
        return view('admin.subject.index', compact('subjects'));
    }

    public function create() {
        $curriculums = Curriculum::where('active', 1)->get();
        return view('admin.subject.create', compact('curriculums'));
    }

    public function store(Request $request) {
        $request->validate([
            'curriculum_id' => 'required|exists:curriculums,id',
            'code' => 'required|unique:subjects,code',
            'name' => 'required',
            'sks' => 'required|numeric|min:1|max:6',
            'semester' => 'required'
        ]);

        $data = $request->all();
        $data['active'] = $request->boolean('active');

        Subject::create($data);
        return redirect()->route('subjects.index')->with('success', 'Mata Kuliah berhasil ditambahkan!');
    }

    public function edit(Subject $subject) {
        $curriculums = Curriculum::where('active', 1)->get();
        return view('admin.subject.edit', compact('subject', 'curriculums'));
    }

    public function update(Request $request, Subject $subject) {
        $request->validate([
            'curriculum_id' => 'required|exists:curriculums,id',
            // Rahasia: Abaikan ID sendiri saat cek unik agar tidak error saat klik simpan
            'code' => 'required|unique:subjects,code,' . $subject->id,
            'name' => 'required',
            'sks' => 'required|numeric|min:1|max:6',
            'semester' => 'required'
        ]);

        $data = $request->all();
        $data['active'] = $request->boolean('active');

        $subject->update($data);
        return redirect()->route('subjects.index')->with('success', 'Data Mata Kuliah berhasil diperbarui!');
    }

    public function destroy(Subject $subject) {
        $subject->delete();
        return redirect()->route('subjects.index')->with('success', 'Mata Kuliah telah dihapus.');
    }
}