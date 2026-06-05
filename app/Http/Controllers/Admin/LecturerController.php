<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class LecturerController extends Controller
{
    /**
     * Menampilkan daftar seluruh dosen & staff
     */
    public function index()
    {
        // Mengambil data beserta relasi atasan (leader) agar tidak berat
        $lecturers = Lecturer::with('leader')->latest()->get();
        return view('admin.lecturer.index', compact('lecturers'));
    }

    /**
     * Form tambah personel baru
     */
    public function create()
    {
        // Ambil data untuk pilihan atasan langsung (organogram)
        $leaders = Lecturer::orderBy('name', 'asc')->get();
        return view('admin.lecturer.create', compact('leaders'));
    }

    /**
     * Proses simpan data dosen & riwayat pendidikan
     */
    public function store(Request $request)
    {
        $request->validate([
            'nip_nidn' => 'required|unique:lecturers,nip_nidn',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:lecturers,email',
            'academic_position' => 'required',
            'sinta_url' => 'nullable|url',
            'pddikti_url' => 'nullable|url',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        // Pastikan active tersimpan sebagai 1 atau 0
        $data['active'] = $request->has('active') ? 1 : 0;
        $data['created_by'] = Auth::id(); // Audit Trail

        // Handle Upload Foto
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('lecturers', 'public');
        }

        // Simpan Data Utama
        $lecturer = Lecturer::create($data);

        // Simpan Banyak Riwayat Pendidikan (Array)
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

        return redirect()->route('lecturers.index')->with('success', 'Personel berhasil ditambahkan!');
    }

    /**
     * Form edit personel
     */
    public function edit(Lecturer $lecturer)
    {
        $leaders = Lecturer::where('id', '!=', $lecturer->id)->orderBy('name', 'asc')->get();
        return view('admin.lecturer.edit', compact('lecturer', 'leaders'));
    }

    /**
     * Proses update data personel
     */
    public function update(Request $request, Lecturer $lecturer)
    {
        $request->validate([
            'nip_nidn' => 'required|unique:lecturers,nip_nidn,' . $lecturer->id,
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:lecturers,email,' . $lecturer->id,
        ]);

        $data = $request->all();
        $data['active'] = $request->has('active') ? 1 : 0;
        $data['updated_by'] = Auth::id(); // Audit Trail

        // Update Foto jika ada file baru
        if ($request->hasFile('image')) {
            if ($lecturer->image) {
                Storage::disk('public')->delete($lecturer->image);
            }
            $data['image'] = $request->file('image')->store('lecturers', 'public');
        }

        $lecturer->update($data);

        // Update Pendidikan (Hapus data lama, isi denga data baru dari form)
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

        return redirect()->route('lecturers.index')->with('success', 'Data berhasil diperbarui!');
    }

    /**
     * Hapus personel
     */
    public function destroy(Lecturer $lecturer)
    {
        if ($lecturer->image) {
            Storage::disk('public')->delete($lecturer->image);
        }
        $lecturer->delete(); // Otomatis menghapus pendidikan karena relasi cascade
        return redirect()->route('lecturers.index')->with('success', 'Data personel telah dihapus.');
    }

    /**
     * Menampilkan struktur organisasi (khusus admin)
     */
    public function structure()
    {
        $pimpinan = Lecturer::whereNull('parent_id')->with('subordinates')->get();
        return view('admin.lecturer.structure', compact('pimpinan'));
    }
}