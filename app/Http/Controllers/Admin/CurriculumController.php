<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Curriculum;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CurriculumController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil semua kurikulum untuk tabel bawah
        $curriculums = Curriculum::withCount('subjects')->latest()->paginate(5);

        // 2. Pilih Kurikulum yang sedang aktif untuk ditampilkan statistiknya
        $activeCurriculum = Curriculum::where('active', 1)->first() ?? Curriculum::latest()->first();

        // 3. Query Mata Kuliah dari kurikulum aktif tersebut
        $subjectQuery = Subject::where('curriculum_id', $activeCurriculum->id);

        // Filter Pencarian Mata Kuliah
        if ($request->filled('search_subject')) {
            $subjectQuery->where('name', 'like', '%' . $request->search_subject . '%')
                        ->orWhere('code', 'like', '%' . $request->search_subject . '%');
        }

        // Filter per Semester
        if ($request->filled('semester')) {
            $subjectQuery->where('semester', $request->semester);
        }

        $subjects = $subjectQuery->orderBy('semester')->orderBy('code')->get();

        // 4. Hitung total MK per semester untuk Card (Smt 1 - 8)
        $stats = [];
        for ($i = 1; $i <= 8; $i++) {
            $stats[$i] = Subject::where('curriculum_id', $activeCurriculum->id)->where('semester', $i)->count();
        }

        return view('admin.curriculum.index', compact('curriculums', 'activeCurriculum', 'subjects', 'stats'));
    }

    public function create()
    {
        return view('admin.curriculum.create');
    }

    /**
     * PERBAIKAN: Simpan Kurikulum + Mata Kuliah Sekaligus
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subject_name.*' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // 1. Simpan Wadah Kurikulum
            $curriculum = Curriculum::create([
                'name' => $request->name,
                'active' => $request->has('active'),
                'created_by' => auth()->id()
            ]);

            // 2. Simpan Isi Mata Kuliah (Looping Array)
            if ($request->has('subject_name')) {
                foreach ($request->subject_name as $key => $name) {
                    if (!empty($name)) {
                        $curriculum->subjects()->create([
                            'code'        => $request->subject_code[$key] ?? 'TBA',
                            'name'        => $name,
                            'sks'         => $request->subject_sks[$key] ?? 2,
                            'semester'    => $request->subject_semester[$key],
                            'description' => $request->subject_description[$key] ?? null,
                            'created_by'  => auth()->id(),
                            'active'      => true
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('curriculums.index')->with('success', 'Kurikulum dan seluruh Mata Kuliah berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal simpan kurikulum lengkap: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Terjadi kesalahan sistem.');
        }
    }

    public function show(Curriculum $curriculum)
    {
        $curriculum->load(['subjects' => function($q) {
            $q->orderBy('semester', 'asc');
        }]);
        return view('admin.curriculum.show', compact('curriculum'));
    }

    public function edit(Curriculum $curriculum)
    {
        $curriculum->load('subjects');
        return view('admin.curriculum.edit', compact('curriculum'));
    }

    /**
     * UPDATE: Menggunakan teknik Clean Slate (Sudah Benar)
     */
    public function update(Request $request, Curriculum $curriculum)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subject_name.*' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // 1. Update Wadah
            $curriculum->update([
                'name' => $request->name,
                'active' => $request->has('active'),
                'updated_by' => auth()->id()
            ]);

            // 2. Hapus yang lama, ganti denga yang baru (Clean Slate)
            $curriculum->subjects()->delete();

            // 3. Simpan Ulang Semua dari Form
            if ($request->has('subject_name')) {
                foreach ($request->subject_name as $key => $name) {
                    if (!empty($name)) {
                        $curriculum->subjects()->create([
                            'code'        => $request->subject_code[$key] ?? 'TBA',
                            'name'        => $name,
                            'sks'         => $request->subject_sks[$key] ?? 2,
                            'semester'    => $request->subject_semester[$key],
                            'description' => $request->subject_description[$key] ?? null,
                            'created_by'  => auth()->id(),
                            'active'      => true
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('curriculums.index')->with('success', 'Sinkronisasi Kurikulum Berhasil!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal update kurikulum: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal memperbarui data.');
        }
    }

    public function destroy(Curriculum $curriculum)
    {
        try {
            DB::beginTransaction();
            // cascadeOnDelete di Migration akan menghapus matakuliah otomatis
            $curriculum->delete();
            DB::commit();
            return redirect()->route('curriculums.index')->with('success', 'Kurikulum dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal hapus data.');
        }
    }

    public function updateSemester(Request $request, Curriculum $curriculum, $semester)
    {
        DB::beginTransaction();
        try {
            // 1. Hapus hanya mata kuliah di semester yang dipilih
            $curriculum->subjects()->where('semester', $semester)->delete();

            // 2. Simpan data baru untuk semester tersebut
            if ($request->has('subject_name')) {
                foreach ($request->subject_name as $key => $name) {
                    if (!empty($name)) {
                        $curriculum->subjects()->create([
                            'code'        => $request->subject_code[$key],
                            'name'        => $name,
                            'sks'         => $request->subject_sks[$key],
                            'semester'    => $semester,
                            'description' => $request->subject_description[$key],
                            'created_by'  => auth()->id(),
                            'active'      => 1
                        ]);
                    }
                }
            }

            DB::commit();
            return back()->with('success', 'Data Semester ' . $semester . ' berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }
}