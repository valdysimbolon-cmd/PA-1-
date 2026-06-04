<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->get();
        return view('admin.announcement.index', compact('announcements'));
    }

    public function create()
    {
        $announcementCategories = [
        'Reminder', 
        'Akademik', 
        'Kemahasiswaan', 
        'Informasi Fakultas', 
        'Beasiswa / Lowongan', 
        'Umum'
    ];   
            $categories = \App\Models\NewsCategory::where('active', 1)
                  ->where('name', 'NOT LIKE', '%Kegiatan%')
                  ->where('name', 'NOT LIKE', '%Prestasi%')
                  ->get();
        return view('admin.announcement.create', compact('categories'));
    }

public function store(Request $request)
{
    $request->validate([
        'title' => 'required|max:255',
        'content' => 'required',
        'category_id' => 'required',
        'attachment_file' => 'nullable|file|mimes:pdf,jpg,png,docx|max:5120', // NULLABLE = OPSIONAL
    ]);

    $data = $request->all();
    $data['created_by'] = auth()->id();
    $data['active'] = $request->boolean('active', true);
    $data['is_urgent'] = $request->boolean('is_urgent');

    if ($request->hasFile('attachment_file')) {
        $data['attachment_file'] = $request->file('attachment_file')->store('announcements', 'public');
    }

    \App\Models\Announcement::create($data);
    return redirect()->route('announcements.index')->with('success', 'Pengumuman berhasil diterbitkan!');
}

public function update(Request $request, Announcement $announcement)
{
    $request->validate([
        'title' => 'required|max:255',
        'content' => 'required',
        'category_id' => 'required',
    ]);

    $data = $request->all();
    $data['active'] = $request->has('active') ? 1 : 0;
    $data['is_urgent'] = $request->has('is_urgent') ? 1 : 0;
    $data['updated_by'] = auth()->id();

    if ($request->hasFile('attachment_file')) {
        if ($announcement->attachment_file) {
            \Storage::disk('public')->delete($announcement->attachment_file);
        }
        $data['attachment_file'] = $request->file('attachment_file')->store('announcements', 'public');
    }

    // Eksekusi Update
    $announcement->update($data);

    return redirect()->route('announcements.index')->with('success', 'Pengumuman Berhasil Diperbarui!');
}

    public function edit(Announcement $announcement)
    {
        // Gunakan filter yang sama agar konsisten
        $categories = \App\Models\NewsCategory::where('active', 1)
                      ->where('name', 'NOT LIKE', '%Kegiatan%')
                      ->where('name', 'NOT LIKE', '%Prestasi%')
                      ->get();
        return view('admin.announcement.edit', compact('announcement', 'categories'));
    }


    public function destroy(Announcement $announcement)
    {
        if ($announcement->attachment_file) {
            Storage::disk('public')->delete($announcement->attachment_file);
        }
        $announcement->delete();
        return redirect()->route('announcements.index')->with('success', 'Pengumuman dihapus.');
    }
}