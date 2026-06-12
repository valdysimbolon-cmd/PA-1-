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

        return view('guest.beranda', compact(
            'hero', 'latestNews', 'mitras', 'profiles', 'stats', 'testimonials'
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
    // 1. Ambil semua data personel yang aktif
    $allPersonel = \App\Models\Lecturer::where('active', 1)->orderBy('name', 'asc')->get();

    // 2. Tentukan jabatan apa saja yang masuk kategori STAFF
    $staffRoles = ['Laboran', 'Teaching Assistant', 'Staff Administrasi', 'Teknisi', 'Kebersihan', 'Lainnya'];

    // 3. Pisahkan menjadi dua kelompok menggunakan filter collection Laravel
    // Kelompok DOSEN (yang jabatannya tidak ada di daftar staffRoles)
    $lecturers = $allPersonel->filter(function ($item) use ($staffRoles) {
        return !in_array($item->academic_position, $staffRoles);
    });

    // Kelompok STAF (yang jabatannya ada di daftar staffRoles)
    $staf = $allPersonel->filter(function ($item) use ($staffRoles) {
        return in_array($item->academic_position, $staffRoles);
    });

    // 4. Kirim KEDUA variabel ke view
    return view('guest.profil_dosen_staff', compact('lecturers', 'staf'));
}

    // 2. Halaman DETAIL Dosen (Page Baru)
    public function lecturerDetail($id)
    {
        // Ambil data lengkap denga Eager Loading semua relasi akademik
        $person = Lecturer::with(['educations', 'publications.publication', 'achievements'])
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
    // Ganti ->get() menjadi ->paginate(15) agar fungsi links() bisa berjalan
    $achievements = \App\Models\Achievement::where('active', 1)
                    ->latest()
                    ->paginate(15);

    // Ambil data berita prestasi (cerita)
    $newsPrestasi = \App\Models\News::whereHas('category', function($q) {
                        $q->where('name', 'LIKE', '%Prestasi%');
                    })
                    ->where('active', 1)
                    ->latest()
                    ->get();

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

public function allMitra()
{
    // Ambil data mitra yang aktif
    $mitras = \App\Models\Cooperation::where('active', 1)->orderBy('name', 'asc')->get();
    return view('guest.mitra', compact('mitras'));
}

public function showMitra($id)
{
    // Ambil detail satu mitra
    $mitra = \App\Models\Cooperation::findOrFail($id);
    return view('guest.mitra_detail', compact('mitra'));
}

public function allTestimonials()
{
    $testimonials = Testimonial::where('active', 1)
                    ->latest()
                    ->paginate(9);

    return view('guest.testimoni', compact('testimonials'));
}
public function showTestimonial($id)
{
    // Mengambil satu data testimoni berdasarkan ID
    $testi = \App\Models\Testimonial::findOrFail($id);

    // Mengirim variabel 'testi' ke view
    return view('guest.testimoni_detail', compact('testi'));
}
public function allLabs()
{
    // Ambil semua lab yang aktif
    $labs = \App\Models\Lab::where('active', 1)->get();
    return view('guest.lab_index', compact('labs'));
}

public function showLab($slug)
{
    // Ambil satu lab berdasarkan slug beserta alat-alatnya
    $lab = \App\Models\Lab::with(['head', 'staff', 'tools'])
          ->where('slug', $slug)
          ->where('active', 1)
          ->firstOrFail();

    return view('guest.lab_detail', compact('lab'));
}


public function allFacilities()
{
    // Mengambil data fasilitas yang aktif
    $facilities = \App\Models\Facility::all();
    
    // Membuka file resources/views/guest/sarana.blade.php
    return view('guest.sarana', compact('facilities'));
}

public function beasiswa()
{
    // Mengambil data dari tabel profiles berdasarkan key
    $data = \App\Models\Profile::where('key', 'A_BEASISWA')
            ->where('active', 1)
            ->firstOrFail();

    return view('guest.beasiswa', compact('data'));
}

}