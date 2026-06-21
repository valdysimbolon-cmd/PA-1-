<?php

namespace App\Http\Controllers\Guest\Beranda;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\Cooperation;
use App\Models\Hero;
use App\Models\Information;
use App\Models\Lab;
use App\Models\Profile;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        // Hero aktif, jika tidak ada ambil hero terbaru
        $hero = Hero::where('active', 1)->first()
            ?? Hero::latest()->first();

        // 4 berita terbaru
        $latestNews = Information::news()
            ->active()
            ->latest('published_at')
            ->take(4)
            ->get();

        // 3 prestasi terbaru
        $latestAchievements = Achievement::where('active', 1)
            ->latest('year')
            ->take(3)
            ->get();

        // Testimoni aktif
        $testimonials = Testimonial::where('active', 1)
            ->latest()
            ->paginate(9);

        // Profil untuk bagian Beranda, misalnya key: B_VISIMISI, B_SEJARAH, dll.
        $profiles = Profile::where('active', 1)
            ->where('key', 'LIKE', 'B_%')
            ->get()
            ->keyBy('key');

        // Mitra kerja sama aktif
        $mitras = Cooperation::where('active', 1)->get();

        // Pengumuman aktif dan belum kedaluwarsa
        $announcements = Information::announcements()
            ->active()
            ->valid()
            ->orderBy('is_important', 'desc')
            ->latest()
            ->take(5)
            ->get();

        // Statistik beranda
        $stats = [
            'labs' => Lab::where('active', 1)->count(),
            'mitras' => $mitras->count(),
        ];

        return view('guest.beranda', compact(
            'hero',
            'latestNews',
            'latestAchievements',
            'testimonials',
            'profiles',
            'mitras',
            'announcements',
            'stats'
        ));
    }
}