<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\News;
use App\Models\Achievement;
use App\Models\Lecturer;
use App\Models\Facility;
use App\Models\Lab;
use App\Models\Subject; // Ganti sesuai model yang digunakan
use App\Models\Cooperation;
use App\Models\Scholarship;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik Bulanan Berita
        $monthlyNews = [];

        for ($i = 1; $i <= 12; $i++) {
            $monthlyNews[] = News::whereYear('created_at', now()->year)
                ->whereMonth('created_at', $i)
                ->count();
        }

        // Aktivitas terbaru
        $latestNews = News::latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', [

            // Statistik
            'newsCount'        => News::count(),
            'achievementCount' => Achievement::count(),
            'lecturerCount'    => Lecturer::count(),
            'facilityCount'    => Facility::count(),
            'labCount'         => Lab::count(),
            'courseCount'      => Subject::count(),
            'cooperationCount' => Cooperation::count(),

            // Grafik
            'monthlyNews'      => $monthlyNews,

            // Aktivitas
            'latestNews'       => $latestNews,

            // Sistem
            'serverTime'       => now()->format('H:i'),
        ]);
    }
}