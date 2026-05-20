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
        return view('admin.announcement.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'attachment_file' => 'nullable|file|mimes:pdf,jpg,png,docx|max:5120', // Maks 5MB
            'expired_at' => 'nullable|date',
        ]);

        $data = $request->all();
        $data['active'] = $request->boolean('active');
        $data['is_urgent'] = $request->boolean('is_urgent');

        if ($request->hasFile('attachment_file')) {
            $data['attachment_file'] = $request->file('attachment_file')->store('announcements', 'public');
        }

        Announcement::create($data);

        return redirect()->route('announcements.index')->with('success', 'Pengumuman berhasil diposting!');
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.announcement.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'attachment_file' => 'nullable|file|mimes:pdf,jpg,png,docx|max:5120',
        ]);

        $data = $request->all();
        $data['active'] = $request->boolean('active');
        $data['is_urgent'] = $request->boolean('is_urgent');

        if ($request->hasFile('attachment_file')) {
            if ($announcement->attachment_file) {
                Storage::disk('public')->delete($announcement->attachment_file);
            }
            $data['attachment_file'] = $request->file('attachment_file')->store('announcements', 'public');
        }

        $announcement->update($data);
        return redirect()->route('announcements.index')->with('success', 'Pengumuman diperbarui!');
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