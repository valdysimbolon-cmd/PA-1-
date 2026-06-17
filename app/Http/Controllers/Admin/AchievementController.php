<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\AchievementRelation;
use App\Models\Student;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AchievementController extends Controller
{
    /**
     * Daftar prestasi
     */
    public function index(Request $request)
    {
        $query = Achievement::with('members');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        $achievements = $query->latest()->paginate(10)->withQueryString();

        return view('admin.achievement.index', compact('achievements'));
    }
    /**
     * Form tambah prestasi
     */
    public function create()
    {
        $students = Student::where('active', 1)
            ->orderBy('name')
            ->get();

        $lecturers = Lecturer::where('active', 1)
            ->orderBy('name')
            ->get();

        return view('admin.achievement.create', compact('students', 'lecturers'));
    }

    /**
     * Simpan prestasi
     */
    public function store(Request $request)
    {
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

            $data['active'] = $request->boolean('active', true);
            $data['created_by'] = Auth::id();

            if ($request->hasFile('image')) {
                $data['image'] = $request
                    ->file('image')
                    ->store('achievements', 'public');
            }

            $achievement = Achievement::create($data);

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
     * Form edit prestasi
     */
    public function edit(Achievement $achievement)
    {
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
     * Update prestasi
     */
    public function update(Request $request, Achievement $achievement)
    {
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

            if ($request->hasFile('image')) {

                if (
                    $achievement->image &&
                    Storage::disk('public')->exists($achievement->image)
                ) {
                    Storage::disk('public')->delete($achievement->image);
                }

                $data['image'] = $request
                    ->file('image')
                    ->store('achievements', 'public');
            }

            $achievement->update($data);

            // Hapus relasi lama
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
     * Hapus prestasi
     */
    public function destroy(Achievement $achievement)
    {
        DB::beginTransaction();

        try {

            if (
                $achievement->image &&
                Storage::disk('public')->exists($achievement->image)
            ) {
                Storage::disk('public')->delete($achievement->image);
            }

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