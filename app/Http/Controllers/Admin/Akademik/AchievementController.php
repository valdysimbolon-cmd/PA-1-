<?php

namespace App\Http\Controllers\Admin\Akademik;

use Exception;
use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\AchievementRelation;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Class AchievementController
 * 
 * Mengelola data prestasi (mahasiswa/dosen) beserta anggota tim terkait.
 * Mendukung operasi CRUD, filter, serta unggah gambar bukti prestasi.
 */
class AchievementController extends Controller
{
    /**
     * Menampilkan daftar prestasi dengan filter pencarian, kategori, dan tahun.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Achievement::with('members');

        // Filter berdasarkan kata kunci pada judul
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        // Filter berdasarkan kategori (student/lecturer)
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        // Filter berdasarkan tahun
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        // Paginasi dengan tetap mempertahankan query string filter
        $achievements = $query->latest()->paginate(10)->withQueryString();

        return view('admin.achievement.index', compact('achievements'));
    }

    /**
     * Menampilkan form tambah prestasi.
     * Menyediakan daftar dosen untuk dipilih sebagai anggota tim (jika diperlukan).
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Ambil data dosen aktif untuk pilihan anggota tim
        $lecturers = Lecturer::where('active', 1)
            ->orderBy('name')
            ->get();

        return view('admin.achievement.create', compact('lecturers')); // Perhatikan: variabel $students tidak didefinisikan, sesuaikan view
    }

    /**
     * Menyimpan data prestasi baru beserta relasi anggota tim.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input utama dan array anggota tim
        $request->validate([
            'category'     => 'required|in:student,lecturer',
            'winner_name'  => 'required|string|max:255',
            'title'        => 'required|string|max:255',
            'rank'         => 'nullable|string|max:100',
            'level'        => 'required|in:Regional,Nasional,Internasional',
            'year'         => 'required|digits:4',
            'image'        => 'nullable|image|max:2048',

            'member_ids.*'   => 'nullable',
            'member_types.*' => 'nullable|in:Student,Lecturer',
            'roles.*'        => 'nullable|string|max:100',
        ]);

        DB::beginTransaction();

        try {
            // Siapkan data utama
            $data = $request->all();
            $data['active'] = $request->boolean('active', true);
            $data['created_by'] = Auth::id();

            // Upload gambar jika ada
            if ($request->hasFile('image')) {
                $data['image'] = $request
                    ->file('image')
                    ->store('achievements', 'public');
            }

            // Simpan prestasi
            $achievement = Achievement::create($data);

            // Simpan relasi anggota tim (jika ada)
            if ($request->has('member_ids')) {
                foreach ($request->member_ids as $index => $memberId) {
                    if (!empty($memberId)) {
                        AchievementRelation::create([
                            'achievement_id' => $achievement->id,
                            'member_id'      => $memberId,
                            'member_type'    => $request->member_types[$index] ?? null,
                            'role'           => $request->roles[$index] ?? null,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()
                ->route('achievements.index')
                ->with('success', 'Prestasi berhasil ditambahkan.');
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Gagal menyimpan prestasi', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data prestasi.');
        }
    }

    /**
     * Menampilkan form edit prestasi beserta data anggota tim yang sudah ada.
     *
     * @param Achievement $achievement
     * @return \Illuminate\View\View
     */
    public function edit(Achievement $achievement)
    {
        // Ambil data dosen dan mahasiswa (asumsi model Student ada)
        // Catatan: variabel $students tidak didefinisikan, pastikan model Student di-import
        $students = Student::where('active', 1)
            ->orderBy('name')
            ->get();

        $lecturers = Lecturer::where('active', 1)
            ->orderBy('name')
            ->get();

        $achievement->load('members');

        return view(
            'admin.achievement.edit',
            compact('achievement', 'students', 'lecturers')
        );
    }

    /**
     * Memperbarui data prestasi yang sudah ada.
     *
     * @param Request $request
     * @param Achievement $achievement
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Achievement $achievement)
    {
        // Validasi input
        $request->validate([
            'category'     => 'required|in:student,lecturer',
            'winner_name'  => 'required|string|max:255',
            'title'        => 'required|string|max:255',
            'rank'         => 'nullable|string|max:100',
            'level'        => 'required|in:Regional,Nasional,Internasional',
            'year'         => 'required|digits:4',
            'image'        => 'nullable|image|max:2048',

            'member_ids.*'   => 'nullable',
            'member_types.*' => 'nullable|in:Student,Lecturer',
            'roles.*'        => 'nullable|string|max:100',
        ]);

        DB::beginTransaction();

        try {
            $data = $request->all();
            $data['active'] = $request->boolean('active');
            $data['updated_by'] = Auth::id();

            // Proses unggah gambar baru (hapus gambar lama jika ada)
            if ($request->hasFile('image')) {
                if ($achievement->image && Storage::disk('public')->exists($achievement->image)) {
                    Storage::disk('public')->delete($achievement->image);
                }
                $data['image'] = $request
                    ->file('image')
                    ->store('achievements', 'public');
            }

            // Update data utama
            $achievement->update($data);

            // Hapus relasi anggota tim lama
            $achievement->members()->delete();

            // Simpan relasi baru
            if ($request->has('member_ids')) {
                foreach ($request->member_ids as $index => $memberId) {
                    if (!empty($memberId)) {
                        AchievementRelation::create([
                            'achievement_id' => $achievement->id,
                            'member_id'      => $memberId,
                            'member_type'    => $request->member_types[$index] ?? null,
                            'role'           => $request->roles[$index] ?? null,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()
                ->route('achievements.index')
                ->with('success', 'Prestasi berhasil diperbarui.');
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Gagal update prestasi', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui prestasi.');
        }
    }

    /**
     * Menghapus data prestasi beserta gambar dan relasi anggota tim.
     *
     * @param Achievement $achievement
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Achievement $achievement)
    {
        DB::beginTransaction();

        try {
            // Hapus file gambar jika ada
            if ($achievement->image && Storage::disk('public')->exists($achievement->image)) {
                Storage::disk('public')->delete($achievement->image);
            }

            // Hapus record (relasi akan terhapus otomatis jika cascade)
            $achievement->delete();

            DB::commit();

            return redirect()
                ->route('achievements.index')
                ->with('success', 'Prestasi berhasil dihapus.');
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Gagal hapus prestasi', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            return redirect()
                ->route('achievements.index')
                ->with('error', 'Prestasi gagal dihapus.');
        }
    }
}