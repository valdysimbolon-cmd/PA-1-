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
        // Ganti $leaders menjadi $lecturers agar sesuai dengan compact
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
    // 1. Validasi Identitas
    $request->validate([
        'nip_nidn' => 'required|unique:lecturers,nip_nidn',
        'name' => 'required',
        'email' => 'required|email|unique:lecturers,email',
        'academic_position' => 'required',
        'image' => 'nullable|image|max:2048',
    ]);

    $data = $request->all();
    $data['active'] = $request->has('active') ? 1 : 0;
    $data['created_by'] = auth()->id();

    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('lecturers', 'public');
    }

    // 2. Simpan Data Dosen
    $lecturer = Lecturer::create($data);

    // 3. Simpan Banyak Riwayat Pendidikan (Looping)
    if ($request->has('degree')) {
        foreach ($request->degree as $key => $val) {
            // Hanya simpan jika "Gelar" diisi (menghindari baris kosong tersimpan)
            if (!empty($val)) {
                $lecturer->educations()->create([
                    'degree'          => $request->degree[$key],
                    'campus'          => $request->campus[$key] ?? '-',
                    'study_program'   => $request->study_program[$key] ?? '-',
                    'graduation_year' => $request->graduation_year[$key] ?? null,
                ]);
            }
        }
    }

    return redirect()->route('lecturers.index')->with('success', 'Dosen dan seluruh riwayat pendidikan berhasil disimpan!');
}

public function update(Request $request, Lecturer $lecturer)
{
    $request->validate([
        'nip_nidn' => 'required|unique:lecturers,nip_nidn,' . $lecturer->id,
        'name' => 'required',
        'email' => 'required|email|unique:lecturers,email,' . $lecturer->id,
    ]);

    $data = $request->all();
    $data['active'] = $request->has('active') ? 1 : 0;
    $data['updated_by'] = auth()->id();

    if ($request->hasFile('image')) {
        if ($lecturer->image) \Storage::disk('public')->delete($lecturer->image);
        $data['image'] = $request->file('image')->store('lecturers', 'public');
    }

    $lecturer->update($data);

    // Update Pendidikan
    $lecturer->educations()->delete();
    if ($request->has('degree')) {
        foreach ($request->degree as $key => $val) {
            if (!empty($val)) {
                $lecturer->educations()->create([
                    'degree'          => $request->degree[$key],
                    'campus'          => $request->campus[$key] ?? '-',
                    'study_program'   => $request->study_program[$key] ?? '-',
                    'graduation_year' => $request->graduation_year[$key] ?? null,
                ]);
            }
        }
    }

    return redirect()->route('lecturers.index')->with('success', 'Berhasil diperbarui!');
}

    public function edit(Lecturer $lecturer)
    {
        $leaders = Lecturer::where('id', '!=', $lecturer->id)->orderBy('name', 'asc')->get();
        return view('admin.lecturer.edit', compact('lecturer', 'leaders'));
    }

    // INI FUNGSI YANG TADI HILANG/EROR:


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