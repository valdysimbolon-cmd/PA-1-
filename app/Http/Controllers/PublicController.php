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
use App\Models\NewsCategory;
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
        $lecturers = \App\Models\Lecturer::with(['educations', 'publications.publication', 'achievements'])
                    ->where('active', 1)
                    ->orderBy('name', 'asc')
                    ->get();

        return view('guest.profil_dosen_staff', compact('lecturers'));
    }
    // 1. Menu Berita & Kegiatan
    public function news()
    {
        // Hanya ambil berita yang kategorinya BUKAN Prestasi
        $allNews = \App\Models\News::whereHas('category', function($q) {
                        $q->where('name', 'NOT LIKE', '%Prestasi%');
                    })
                    ->where('active', 1)
                    ->latest()
                    ->paginate(9);

        // Ambil kategori khusus kegiatan saja untuk filter kecil di dalam page
        $categories = \App\Models\NewsCategory::where('name', 'NOT LIKE', '%Prestasi%')
                    ->where('active', 1)->get();

        return view('guest.berita', compact('allNews', 'categories'));
    }

    // 2. Menu Prestasi
    public function prestasi()
    {
        // A. Ambil REKAP JUARA dari tabel achievements (Data Teknis)
        $achievements = \App\Models\Achievement::where('active', 1)->latest()->get();

        // B. Ambil ARTIKEL CERITA PRESTASI dari tabel news (Kategori Prestasi)
        $newsPrestasi = \App\Models\News::whereHas('category', function($q) {
                            $q->where('name', 'LIKE', '%Prestasi%');
                        })
                        ->where('active', 1)->latest()->get();

        return view('guest.prestasi', compact('achievements', 'newsPrestasi'));
    }

    public function showNews($id)
    {
        $news = News::findOrFail($id);
        return view('guest.berita_detail', compact('news'));
    }

    public function kurikulum()
    {
        $curriculum = \App\Models\Curriculum::where('active', 1)->first();

        if (!$curriculum) {
            $subjects = collect();
        } else {
            // Ambil semua mata kuliah di kurikulum tersebut
            $subjects = \App\Models\Subject::where('curriculum_id', $curriculum->id)
                        ->where('active', 1)
                        ->orderBy('semester', 'asc')
                        ->get();
        }

        return view('guest.kurikulum', compact('curriculum', 'subjects'));
    }

    public function announcements()
    {
        $announcements = \App\Models\Announcement::where('active', 1)
                        ->latest()
                        ->paginate(10);
        return view('guest.pengumuman', compact('announcements'));
    }

    public function archives()
    {
        // Mengambil semua dokumen dan dikelompokkan berdasarkan kategori
        $archives = \App\Models\DocumentArchive::where('active', 1)
                    ->orderBy('category', 'asc')
                    ->latest()
                    ->get();
        return view('guest.dokumen', compact('archives'));
    }
}