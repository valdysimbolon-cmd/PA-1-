<?php

namespace App\Http\Controllers\Guest\News_Information;

use App\Http\Controllers\Controller;
use App\Models\Information;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    public function news(Request $request)
    {
        $categories = ['Kegiatan Mahasiswa', 'Kegiatan Dosen', 'Kegiatan Umum'];
        $query = Information::news()->active();
        if ($request->filled('category')) $query->where('category', $request->category);
        $items = $query->latest('published_at')->paginate(9);
        return view('guest.information', ['items' => $items, 'categories' => $categories, 'title' => 'Berita & Kegiatan', 'type' => 'news']);
    }

    public function announcements()
    {
        $items = Information::announcements()->active()->valid()->latest()->paginate(10);
        return view('guest.information', ['items' => $items, 'categories' => ['Pengumuman'], 'type' => 'announcement', 'title' => 'Pengumuman']);
    }

    public function showInformation($id)
    {
        $info = Information::active()->findOrFail($id);
        return view('guest.information_detail', compact('info'));
    }
}