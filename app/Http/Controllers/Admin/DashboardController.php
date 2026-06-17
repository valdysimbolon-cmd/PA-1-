<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// Import Model Baru
use App\Models\Information; 
use App\Models\Achievement;
use App\Models\Lecturer;
use App\Models\Facility;
use App\Models\Lab;
use App\Models\Subject; 
use App\Models\Cooperation;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Statistik Bulanan Berita (Menggunakan Model Information tipe news)
        $monthlyNews = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyNews[] = Information::news() // Gunakan scope news
                ->whereYear('published_at', now()->year)
                ->whereMonth('published_at', $i)
                ->count();
        }

        // 2. Berita terbaru (Menggunakan Model Information tipe news)
        $latestNews = Information::news()
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', [
            // Statistik (Gunakan Model Information dengan filter tipe)
            'newsCount'         => Information::news()->count(),
            'announcementCount' => Information::announcements()->count(), // Tambahan statistik Pengumuman
            'achievementCount'  => Achievement::count(),
            'lecturerCount'     => Lecturer::count(),
            'facilityCount'     => Facility::count(),
            'labCount'          => Lab::count(),
            'courseCount'       => Subject::count(),
            'cooperationCount'  => Cooperation::count(),

            // Grafik
            'monthlyNews'      => $monthlyNews,

            // Aktivitas
            'latestNews'       => $latestNews,

            // Sistem
            'serverTime'       => now()->format('H:i'),
        ]);
    }
}