<?php

namespace App\Http\Controllers;

use App\Models\Hero;
use App\Models\News;
use App\Models\Profile;
use App\Models\Testimonial;
use App\Models\Achievement;
use App\Models\Cooperation;
use App\Models\Student;
use App\Models\Lab;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        $hero = Hero::where('active', 1)->first();
        $latestNews = News::where('active', 1)->latest('published_at')->take(3)->get();
        $latestAchievements = Achievement::where('active', 1)->latest('year')->take(3)->get();
        $testimonials = Testimonial::where('active', 1)->inRandomOrder()->take(3)->get();
        
        // Mengambil semua konten (Visi, Misi, Akreditasi, Why Us)
        $profiles = Profile::where('active', 1)->get()->keyBy('key');
        
        $mitras = Cooperation::where('active', 1)->get();

        $stats = [
            'students' => Student::where('active', 1)->count(),
            'labs' => Lab::where('active', 1)->count(),
            'mitras' => $mitras->count(),
        ];

        return view('guest.beranda', compact(
            'hero', 'latestNews', 'latestAchievements', 'mitras', 'profiles', 'stats', 'testimonials'
        ));
    }

    public function profile()
    {
        // PERBAIKAN: Kamu harus ambil data profiles lagi di sini agar Sejarah & Visi muncul
        $profiles = Profile::where('active', 1)->get()->keyBy('key');
        
        // Ambil juga data pimpinan untuk bagan organisasi (Pohon Akar)
        $pimpinan = Lecturer::whereNull('parent_id')->with('subordinates')->first();

        return view('guest.profil_bioproses', compact('profiles', 'pimpinan'));
    }

    public function news()
    {
        $allNews = News::where('active', 1)->latest('published_at')->paginate(9);
        return view('guest.berita', compact('allNews'));
    }

    /**
     * Menampilkan detail satu berita
     */
    public function showNews($id)
    {
        $news = News::findOrFail($id);
        return view('guest.berita_detail', compact('news'));
    }
}