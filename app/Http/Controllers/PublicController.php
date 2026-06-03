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

           $latestAnnouncements = \App\Models\Announcement::where('active', 1)
                            ->latest()
                            ->take(5)
                            ->get();

        return view('guest.beranda', compact(
        'hero', 'latestNews', 'latestAnnouncements', 'mitras', 'profiles', 'stats', 'testimonials'
        ));
    }

    public function profilBioproses() 
    {
    $profiles = Profile::where('active', 1)
                ->where('key', 'LIKE', 'P_%')
                ->orderBy('id', 'asc')
                ->get();

        return view('guest.profil', compact('profiles'));
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
    public function news(Request $request) // Tambahkan Request $request
    {
        // 1. Ambil kategori (Kecuali Prestasi) untuk Sidebar
        $categories = \App\Models\NewsCategory::where('active', 1)
                    ->where('name', 'NOT LIKE', '%Prestasi%')
                    ->get();

        // 2. Query Berita (Kecuali kategori Prestasi)
        $query = \App\Models\News::with('category')
                    ->whereHas('category', function($q) {
                        $q->where('name', 'NOT LIKE', '%Prestasi%');
                    })
                    ->where('active', 1);

        // 3. LOGIKA FILTER: Jika user klik kategori di sidebar (?category=ID)
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        $allNews = $query->latest('published_at')->paginate(9); 

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