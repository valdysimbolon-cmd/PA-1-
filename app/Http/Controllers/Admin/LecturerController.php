<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LecturerController extends Controller
{
    public function index()
    {
        $lecturers = Lecturer::with('leader')->latest()->get();
        return view('admin.lecturer.index', compact('lecturers'));
    }

    public function create()
    {
        $leaders = Lecturer::orderBy('name', 'asc')->get();
        return view('admin.lecturer.create', compact('leaders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip_nidn' => 'required|unique:lecturers,nip_nidn',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:lecturers,email',
            'academic_position' => 'required',
            'academic_level' => 'required',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        $data['active'] = $request->boolean('active');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('lecturers', 'public');
        }

        $lecturer = Lecturer::create($data);

        // Simpan Pendidikan
        if ($request->has('degree')) {
            foreach ($request->degree as $key => $val) {
                if (!empty($val)) {
                    $lecturer->educations()->create([
                        'degree'        => $request->degree[$key],
                        'campus'        => $request->campus[$key] ?? '-',
                        'study_program' => $request->study_program[$key] ?? '-',
                    ]);
                }
            }
        }

        return redirect()->route('lecturers.index')->with('success', 'Personel berhasil ditambahkan!');
    }

    public function edit(Lecturer $lecturer)
    {
        $leaders = Lecturer::where('id', '!=', $lecturer->id)->orderBy('name', 'asc')->get();
        return view('admin.lecturer.edit', compact('lecturer', 'leaders'));
    }

    // INI FUNGSI YANG TADI HILANG/EROR:
    public function update(Request $request, Lecturer $lecturer)
    {
        $request->validate([
            'nip_nidn' => 'required|unique:lecturers,nip_nidn,' . $lecturer->id,
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:lecturers,email,' . $lecturer->id,
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        $data['active'] = $request->boolean('active');

        if ($request->hasFile('image')) {
            if ($lecturer->image) {
                Storage::disk('public')->delete($lecturer->image);
            }
            $data['image'] = $request->file('image')->store('lecturers', 'public');
        }

        $lecturer->update($data);

        // Update Pendidikan (Clean Slate)
        $lecturer->educations()->delete();
        if ($request->has('degree')) {
            foreach ($request->degree as $key => $val) {
                if (!empty($val)) {
                    $lecturer->educations()->create([
                        'degree'        => $request->degree[$key],
                        'campus'        => $request->campus[$key] ?? '-',
                        'study_program' => $request->study_program[$key] ?? '-',
                    ]);
                }
            }
        }

        return redirect()->route('lecturers.index')->with('success', 'Data diperbarui!');
    }

    public function destroy(Lecturer $lecturer)
    {
        if ($lecturer->image) {
            Storage::disk('public')->delete($lecturer->image);
        }
        $lecturer->delete();
        return redirect()->route('lecturers.index')->with('success', 'Personel telah dihapus!');
    }

    public function structure()
    {
        $pimpinan = Lecturer::whereNull('parent_id')->with('subordinates')->get();
        return view('admin.lecturer.structure', compact('pimpinan'));
    }
}