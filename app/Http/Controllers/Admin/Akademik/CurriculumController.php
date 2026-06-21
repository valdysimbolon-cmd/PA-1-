<?php

namespace App\Http\Controllers\Admin\Akademik;

use App\Http\Controllers\Controller;
use App\Models\Curriculum;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class CurriculumController
 * 
 * Mengelola data kurikulum dan mata kuliah terkait.
 * Mendukung fitur pembuatan, pembaruan, penghapusan kurikulum,
 * serta manajemen mata kuliah per semester.
 */
class CurriculumController extends Controller
{
    /**
     * Menampilkan daftar kurikulum, kurikulum aktif, dan daftar mata kuliah
     * dari kurikulum yang sedang aktif dengan paginasi dan filter.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // 1. Ambil semua kurikulum untuk tabel bawah (dengan paginasi)
        $curriculums = Curriculum::withCount('subjects')->latest()->paginate(5);

        // 2. Pilih kurikulum yang sedang aktif, jika tidak ada ambil yang terbaru
        $activeCurriculum = Curriculum::where('active', 1)->first() ?? Curriculum::latest()->first();

        // Inisialisasi variabel default
        $subjects = collect();
        $stats = array_fill(1, 8, 0);

        if ($activeCurriculum) {
            // 3. Query mata kuliah berdasarkan kurikulum aktif
            $subjectQuery = Subject::where('curriculum_id', $activeCurriculum->id);

            // Filter pencarian (nama/kode mata kuliah)
            if ($request->filled('search_subject')) {
                $search = $request->search_subject;
                $subjectQuery->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('code', 'like', '%' . $search . '%');
                });
            }

            // Filter berdasarkan semester
            if ($request->filled('semester')) {
                $subjectQuery->where('semester', $request->semester);
            }

            // Paginasi hasil mata kuliah (15 per halaman) dengan mempertahankan filter
            $subjects = $subjectQuery->orderBy('semester')
                ->orderBy('code')
                ->paginate(15)
                ->appends(request()->query());

            // 4. Hitung total mata kuliah per semester untuk statistik
            $stats = Subject::where('curriculum_id', $activeCurriculum->id)
                ->select('semester', DB::raw('count(*) as total'))
                ->groupBy('semester')
                ->pluck('total', 'semester')
                ->all();
        } else {
            // Jika tidak ada kurikulum, buat paginator kosong agar view tidak error
            $subjects = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 15);
        }

        return view('admin.curriculum.index', compact('curriculums', 'activeCurriculum', 'subjects', 'stats'));
    }

    /**
     * Menampilkan form tambah kurikulum.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.curriculum.create');
    }

    /**
     * Menyimpan kurikulum baru beserta daftar mata kuliah yang dikirimkan.
     * Menggunakan transaksi database untuk menjaga konsistensi.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subject_name.*' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // 1. Simpan data kurikulum
            $curriculum = Curriculum::create([
                'name' => $request->name,
                'active' => $request->has('active'),
                'created_by' => auth()->id()
            ]);

            // 2. Simpan semua mata kuliah yang diinputkan (jika ada)
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

    /**
     * Menampilkan detail kurikulum beserta daftar mata kuliahnya.
     *
     * @param Curriculum $curriculum
     * @return \Illuminate\View\View
     */
    public function show(Curriculum $curriculum)
    {
        // Muat relasi subjects yang diurutkan berdasarkan semester
        $curriculum->load(['subjects' => function ($q) {
            $q->orderBy('semester', 'asc');
        }]);
        return view('admin.curriculum.show', compact('curriculum'));
    }

    /**
     * Menampilkan form edit kurikulum.
     *
     * @param Curriculum $curriculum
     * @return \Illuminate\View\View
     */
    public function edit(Curriculum $curriculum)
    {
        $curriculum->load('subjects');
        return view('admin.curriculum.edit', compact('curriculum'));
    }

    /**
     * Memperbarui kurikulum dengan pendekatan "clean slate":
     * menghapus semua mata kuliah lama dan menyimpan ulang dari input form.
     *
     * @param Request $request
     * @param Curriculum $curriculum
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Curriculum $curriculum)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subject_name.*' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // 1. Update data kurikulum
            $curriculum->update([
                'name' => $request->name,
                'active' => $request->has('active'),
                'updated_by' => auth()->id()
            ]);

            // 2. Hapus semua mata kuliah lama dan simpan ulang
            $curriculum->subjects()->delete();

            // 3. Simpan data mata kuliah baru dari form
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

    /**
     * Menghapus kurikulum beserta seluruh mata kuliah terkait (cascade).
     *
     * @param Curriculum $curriculum
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Curriculum $curriculum)
    {
        try {
            DB::beginTransaction();
            // Relasi akan terhapus otomatis karena cascadeOnDelete di migration
            $curriculum->delete();
            DB::commit();
            return redirect()->route('curriculums.index')->with('success', 'Kurikulum dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal hapus data.');
        }
    }

    /**
     * Memperbarui mata kuliah hanya untuk semester tertentu.
     * Menghapus mata kuliah lama di semester tersebut dan menyimpan yang baru.
     *
     * @param Request $request
     * @param Curriculum $curriculum
     * @param int $semester
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSemester(Request $request, Curriculum $curriculum, $semester)
    {
        DB::beginTransaction();
        try {
            // 1. Hapus mata kuliah di semester yang dipilih
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