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
            'code' => 'required|unique:subjects,code',
            'name' => 'required',
            'sks'  => 'required|numeric|min:1',
            'semester' => 'required',
            'curriculum_id' => 'required'
        ]);

        $data = $request->all();
        $data['created_by'] = auth()->id();

        // Paksa aktif saat dibuat
        $data['active'] = 1;

        Subject::create($data);

        return redirect()->route('subjects.index')
            ->with('success', 'Mata Kuliah ditambahkan!');
    }


    public function edit(Subject $subject) {
        $curriculums = Curriculum::where('active', 1)->get();
        return view('admin.subject.edit', compact('subject', 'curriculums'));
    }

    public function update(Request $request, Subject $subject) {
        $request->validate([
            'curriculum_id' => 'required|exists:curriculums,id',
            'code' => 'required|unique:subjects,code,' . $subject->id,
            'name' => 'required',
            'sks' => 'required|numeric|min:1|max:6',
            'semester' => 'required'
        ]);

        $data = $request->all();

        // Tetap aktif setelah diedit
        $data['active'] = 1;

        $subject->update($data);

        return redirect()->route('subjects.index')
            ->with('success', 'Data Mata Kuliah berhasil diperbarui!');
    }

    public function destroy(Subject $subject) {
        $subject->delete();
        return redirect()->route('subjects.index')->with('success', 'Mata Kuliah telah dihapus.');
    }
}