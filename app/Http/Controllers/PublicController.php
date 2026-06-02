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
use App\Models\Lecturer;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        $hero = Hero::where('active', 1)->first();
        if(!$hero) {
        $hero = Hero::latest()->first();
    }
        $latestNews = News::where('active', 1)->latest('published_at')->take(3)->get();
        $latestAchievements = Achievement::where('active', 1)->latest('year')->take(3)->get();
        $testimonials = Testimonial::where('active', 1)->inRandomOrder()->take(3)->get();
        
        // Mengambil semua konten (Visi, Misi, Akreditasi, Why Us)
        $profiles = Profile::where('active', 1)
                ->where('key', 'LIKE', 'B_%')
                ->get()
                ->keyBy('key');
        
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

    public function profilBioproses() 
    {
    $profiles = Profile::where('active', 1)
                ->where('key', 'LIKE', 'P_%')
                ->orderBy('id', 'asc')
                ->get();

        return view('guest.profil_bioproses', compact('profiles'));
    }

    public function dosenStaff() 
    {
    $lecturers = \App\Models\Lecturer::with('educations')->where('active', 1)->orderBy('name', 'asc')->get();
    return view('guest.profil_dosen_staff', compact('lecturers'));
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