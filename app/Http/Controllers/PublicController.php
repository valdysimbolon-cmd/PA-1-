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
use App\Models\Announcement; 
use App\Models\DocumentArchive;
use App\Models\Curriculum;
use App\Models\Subject;
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

        // Ambil 5 pengumuman terbaru untuk di Beranda
        $latestAnnouncements = Announcement::where('active', 1)
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
    $lecturers = Lecturer::where('active', 1)
        ->whereIn('academic_position', [
            'Asisten Ahli',
            'Lektor',
            'Lektor Kepala',
            'Guru Besar',
            'Tenaga Pengajar'
        ])
        ->orderBy('name')
        ->get();

    $staf = Lecturer::where('active', 1)
        ->whereIn('academic_position', [
            'Laboran',
            'Teaching Assistant',
            'Staff Administrasi',
            'Teknisi',
            'Lainnya'
        ])
        ->orderBy('name')
        ->get();

    return view(
        'guest.profil_dosen_staff',
        compact('lecturers', 'staf')
    );
}

public function lecturerDetail($id)
{
    // Mengambil data dosen denga Eager Loading agar tidak lemot
    $person = \App\Models\Lecturer::with(['educations', 'publications.publication', 'achievements'])
              ->findOrFail($id);

    return view('guest.profil_dosen_detail', compact('person'));
}
    
public function news(Request $request)
{
    // Kategori yang diizinkan untuk halaman BERITA
    $allowedCategories = ['Kegiatan Mahasiswa', 'Kegiatan Dosen', 'Umum'];

    $categories = \App\Models\NewsCategory::whereIn('name', $allowedCategories)
                ->where('active', 1)
                ->get();

    $query = \App\Models\News::with('category')
                ->whereHas('category', function($q) use ($allowedCategories) {
                    $q->whereIn('name', $allowedCategories);
                })
                ->where('active', 1);

    if ($request->filled('category')) {
        $query->where('category_id', $request->category);
    }

    $allNews = $query->latest('published_at')->paginate(9);

    return view('guest.berita', compact('allNews', 'categories'));
}
    public function prestasi()
    {
        $achievements = Achievement::where('active', 1)->latest()->get();
        $newsPrestasi = News::whereHas('category', function($q) {
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
        $curriculum = Curriculum::where('active', 1)->first();
        $subjects = $curriculum 
                    ? Subject::where('curriculum_id', $curriculum->id)->where('active', 1)->orderBy('semester', 'asc')->get()
                    : collect();

        return view('guest.kurikulum', compact('curriculum', 'subjects'));
    }

    // ============================================================
    // PERBAIKAN FINAL FUNGSI ANNOUNCEMENTS
    // ============================================================
public function announcements(Request $request)
{
    $categories = \App\Models\NewsCategory::where('active', 1)->get();
    $query = \App\Models\Announcement::with('category')->where('active', 1);

    if ($request->filled('judul')) {
        $query->where('title', 'LIKE', '%' . $request->judul . '%');
    }
    if ($request->filled('category')) {
        $query->where('category_id', $request->category);
    }

    $announcements = $query->latest()->paginate(20);
    return view('guest.pengumuman', compact('announcements', 'categories'));
}

// FUNGSI PINDAH HALAMAN
public function showAnnouncement($id)
{
    $ann = \App\Models\Announcement::with('category')->findOrFail($id);
    return view('guest.pengumuman_detail', compact('ann'));
}

    public function archives()
    {
        $archives = DocumentArchive::where('active', 1)
                    ->orderBy('category', 'asc')
                    ->latest()
                    ->get();
        return view('guest.dokumen', compact('archives'));
    }

    public function showCivitas()
    {
        // Mengambil semua data dosen yang aktif
        $dosen = \App\Models\Civitas::where('role', 'dosen')->where('active', 1)->orderBy('name', 'asc')->get();
        
        // Mengambil semua data staf pendukung yang aktif
        $staf = \App\Models\Civitas::where('role', 'staf')->where('active', 1)->orderBy('name', 'asc')->get();

        return view('guest.profil_dosen', compact('dosen', 'staf'));
    }

    public function showCivitasDetail($id)
    {
        $person = \App\Models\Civitas::where('active', 1)->findOrFail($id);
        return view('guest.profil_dosen_detail', compact('person'));
    }

    public function showMitra($id)
    {
        $mitra = \App\Models\Cooperation::findOrFail($id);
        return view('guest.mitra_detail', compact('mitra'));
    }
}