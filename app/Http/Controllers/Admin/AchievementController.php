<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\AchievementRelation;
use App\Models\Student;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AchievementController extends Controller
{
    /**
     * Tampilkan semua daftar prestasi
     */
    public function index() {
        $achievements = \App\Models\Achievement::latest()->get();
        return view('admin.achievement.index', compact('achievements'));
    }

    public function create()
    {
        // Ambil data mahasiswa dan dosen untuk pilihan di form
        $students = Student::where('active', 1)->orderBy('name', 'asc')->get();
        $lecturers = Lecturer::where('active', 1)->orderBy('name', 'asc')->get();
        
        return view('admin.achievement.create', compact('students', 'lecturers'));
    }

    /**
     * Menyimpan data prestasi dan relasi anggota tim
     */
    public function store(Request $request) {
        $request->validate([
            'title' => 'required',
            'winner_name' => 'required',
            'level' => 'required',
            'year' => 'required|digits:4',
        ]);

        $data = $request->all();
        $data['created_by'] = auth()->id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('achievements', 'public');
        }

        // 1. Simpan ke tabel Achievements
        $achievement = Achievement::create($data);

        // 2. Simpan ke tabel Jembatan (Relations) jika ada input anggota
        if ($request->has('member_ids')) {
            foreach ($request->member_ids as $index => $id) {
                AchievementRelation::create([
                    'achievement_id' => $achievement->id,
                    'member_id'      => $id,
                    'member_type'    => $request->member_types[$index],
                    'role'           => $request->roles[$index]
                ]);
            }
        }

        return redirect()->route('achievements.index')->with('success', 'Prestasi berhasil dicatat!');
    }

    public function edit(Achievement $achievement)
    {
        $students = Student::where('active', 1)->get();
        $lecturers = Lecturer::where('active', 1)->get();
        $achievement->load('members'); 
        
        return view('admin.achievement.edit', compact('achievement', 'students', 'lecturers'));
    }

    public function update(Request $request, Achievement $achievement)
    {
        $data = $request->all();
        $data['active'] = $request->boolean('active');

        if ($request->hasFile('image')) {
            if ($achievement->image) Storage::disk('public')->delete($achievement->image);
            $data['image'] = $request->file('image')->store('achievements', 'public');
        }

        $achievement->update($data);

        // Update Relasi: Hapus lama, buat baru (Teknik Clean Slate)
        $achievement->members()->delete();
        if ($request->has('member_ids')) {
            foreach ($request->member_ids as $index => $id) {
                AchievementRelation::create([
                    'achievement_id' => $achievement->id,
                    'member_id'      => $id,
                    'member_type'    => $request->member_types[$index],
                    'role'           => $request->roles[$index]
                ]);
            }
        }

        return redirect()->route('achievements.index')->with('success', 'Prestasi diperbarui!');
    }

    public function destroy(Achievement $achievement)
    {
        if ($achievement->image) Storage::disk('public')->delete($achievement->image);
        $achievement->delete();
        return redirect()->route('achievements.index')->with('success', 'Prestasi dihapus!');
    }
}