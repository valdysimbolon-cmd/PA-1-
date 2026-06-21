<?php

namespace App\Http\Controllers\Admin\Beranda;

use App\Http\Controllers\Controller;
// Import Model untuk data statistik
use App\Models\Information;
use App\Models\Achievement;
use App\Models\Lecturer;
use App\Models\Facility;
use App\Models\Lab;
use App\Models\Subject;
use App\Models\Cooperation;

/**
 * Class DashboardController
 *
 * Mengelola tampilan dashboard admin dengan menyajikan berbagai statistik,
 * grafik bulanan, dan informasi terbaru dari berbagai modul (berita, prestasi,
 * dosen, fasilitas, laboratorium, mata kuliah, kerja sama).
 */
class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard dengan data statistik dan aktivitas terkini.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // ---------------------------------------------------------------------
        // 1. Statistik Bulanan Berita (menggunakan model Information tipe 'news')
        // ---------------------------------------------------------------------
        $monthlyNews = [];
        $newsData = Information::news()
            ->whereYear('published_at', now()->year)
            ->selectRaw('MONTH(published_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->all();

        // Inisialisasi array 12 bulan dengan nilai 0, lalu isi dari data yang ada
        $monthlyNews = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyNews[] = $newsData[$i] ?? 0;
        }

        // ---------------------------------------------------------------------
        // 2. Berita terbaru (5 data terakhir dari tipe 'news')
        // ---------------------------------------------------------------------
        $latestNews = Information::news()
            ->latest()
            ->take(5)
            ->get();

        // ---------------------------------------------------------------------
        // 3. Kirim semua data ke view
        // ---------------------------------------------------------------------
        return view('admin.dashboard', [
            // Statistik utama
            'newsCount'         => Information::news()->count(),
            'announcementCount' => Information::announcements()->count(), // tambahan statistik pengumuman
            'achievementCount'  => Achievement::count(),
            'lecturerCount'     => Lecturer::count(),
            'facilityCount'     => Facility::count(),
            'labCount'          => Lab::count(),
            'courseCount'       => Subject::count(),
            'cooperationCount'  => Cooperation::count(),

            // Data grafik
            'monthlyNews'       => $monthlyNews,

            // Aktivitas terbaru
            'latestNews'        => $latestNews,

            // Informasi sistem
            'serverTime'        => now()->format('H:i'),
        ]);
    }
}