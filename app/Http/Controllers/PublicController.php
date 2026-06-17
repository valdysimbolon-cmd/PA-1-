<?php

namespace App\Http\Controllers;

use App\Models\Hero;
use App\Models\Profile;
use App\Models\Testimonial;
use App\Models\Achievement;
use App\Models\Cooperation;
use App\Models\Information;
use App\Models\Student;
use App\Models\Lab;
use App\Models\Lecturer;
use App\Models\DocumentArchive;
use App\Models\Curriculum;
use App\Models\Subject;
use App\Models\Facility;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        $hero = Hero::where('active', 1)->first();
        if(!$hero) {
            $hero = Hero::latest()->first();
        }
        $latestNews = Information::news()->active()->latest('published_at')->take(4)->get();
        $latestAchievements = Achievement::where('active', 1)->latest('year')->take(3)->get();
        $testimonials = Testimonial::where('active', 1)->latest()->paginate(9);
        $accreditation = Profile::where('key', 'B_ACCREDITATION')->first();
        $labCount = Lab::where('active', 1)->count();
        $partnerCount = Cooperation::where('active', 1)->count();
        $profiles = Profile::where('active', 1)
                ->where('key', 'LIKE', 'B_%')
                ->get()
                ->keyBy('key');
        
        $mitras = Cooperation::where('active', 1)->get();
            $announcements = Information::announcements()
                    ->active()
                    ->valid()
                    ->orderBy('is_important', 'desc')
                    ->latest()
                    ->take(5)
                    ->get();

        $stats = [
            'students' => Student::where('active', 1)->count(),
            'labs' => Lab::where('active', 1)->count(),
            'mitras' => $mitras->count(),
        ];

        return view('guest.beranda', compact(
            'hero', 'latestNews', 'mitras', 'profiles', 'stats', 'testimonials',       'labCount', 
        'partnerCount','announcements', 
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

    /**
     * Menampilkan daftar dosen & staf (model Lecturer)
     * Disesuaikan dengan daftar posisi dari admin
     */
    public function dosenStaff()
    {
        // Ambil semua personel aktif
        $allPersonel = Lecturer::where('active', 1)->get();

        // 1. Definisikan hierarki jabatan untuk pengurutan di dalam grup
        $hierarchy = [
            'Guru Besar'       => 1,
            'Lektor Kepala'    => 2,
            'Lektor'           => 3,
            'Asisten Ahli'     => 4,
            'Tenaga Pengajar'  => 5,
            'Teaching Assistant' => 6,
            'Staff Administrasi' => 7,
            'Laboran'          => 8,
            'Teknisi'          => 9,
            'Lainnya'          => 10,
        ];

        // 2. Urutkan berdasarkan hierarki jabatan, lalu Nama
        $sorted = $allPersonel->sortBy(function($item) use ($hierarchy) {
            return [
                $hierarchy[$item->academic_position] ?? 99,
                $item->name
            ];
        })->values();

        // 3. Definisikan grup secara EKSKLUSIF
        // Pastikan posisi "Teaching Assistant" TIDAK masuk dalam array 'Dosen'
        $groups = [
            'Dosen' => [
                'Guru Besar', 
                'Lektor Kepala', 
                'Lektor', 
                'Asisten Ahli', 
                'Tenaga Pengajar'
            ],
            'Teaching Assistant' => [
                'Teaching Assistant'
            ],
            'Staff' => [
                'Staff Administrasi', 
                'Laboran', 
                'Teknisi', 
                'Lainnya'
            ],
        ];

        // 4. Kelompokkan data
        $grouped = [];
        foreach ($groups as $groupName => $positions) {
            $data = $sorted->filter(function ($item) use ($positions) {
                return in_array($item->academic_position, $positions);
            })->values();

            // Hanya masukkan ke array jika ada anggotanya
            if ($data->count() > 0) {
                $grouped[$groupName] = $data;
            }
        }

        // 5. Hitung total
        $totalCount = $allPersonel->count();

        // Kirim 'others' sebagai array kosong jika tidak digunakan
        $others = collect(); 

        return view('guest.profil_dosen_staff', compact('grouped', 'others', 'totalCount'));
    }

    /**
     * Detail personel (dosen atau staf)
     */
    public function lecturerDetail($id)
    {
        $person = Lecturer::with(['educations', 'publications.publication', 'achievements'])
                  ->findOrFail($id);

        return view('guest.profil_dosen_detail', compact('person'));
    }
    
/**
     * Menampilkan daftar berita & kegiatan (Tipe: News)
     */
    public function news(Request $request)
    {
        $categories = [
            'Kegiatan Mahasiswa', 
            'Kegiatan Dosen', 
            'Kegiatan Umum'
        ];

        $query = Information::news()->active();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $allNews = $query->latest('published_at')->paginate(9);

        // UBAH BARIS INI:
        return view('guest.information', [
            'items' => $allNews, // Variabel harus bernama 'items' agar sesuai dengan file blade baru
            'categories' => $categories,
            'title' => 'Berita & Kegiatan',
            'type' => 'news'
        ]);
    }


    /**
     * Menampilkan detail berita
     */
    public function showNews($id)
    {
        // Cari data di model Information
        $info = Information::news()->active()->findOrFail($id);
        
        // UBAH BARIS INI:
        return view('guest.information_detail', compact('info'));
    }

    public function prestasi()
    {
        $achievements = Achievement::where('active', 1)
                        ->latest()
                        ->paginate(15);
        $newsPrestasi = Information::news()->active()
                        ->where(function($q) {
                            $q->where('title', 'LIKE', '%Prestasi%')
                            ->orWhere('content', 'LIKE', '%Prestasi%');
                        })
                        ->latest()
                        ->get();

        return view('guest.prestasi', compact('achievements', 'newsPrestasi'));
    }

    public function kurikulum()
    {
        $curriculum = Curriculum::where('active', 1)->first();
        $subjects = $curriculum 
                    ? Subject::where('curriculum_id', $curriculum->id)->where('active', 1)->orderBy('semester', 'asc')->get()
                    : collect();

        return view('guest.kurikulum', compact('curriculum', 'subjects'));
    }

    public function archives()
    {
        $archives = DocumentArchive::where('active', 1)
                    ->orderBy('year', 'desc') // Urutkan dari tahun terbaru
                    ->orderBy('title', 'asc')  // Kemudian urutkan abjad judul
                    ->get();

        return view('guest.dokumen', compact('archives'));
    }

    // ============================================================
    // METHOD SHOW CIVITAS DIHAPUS KARENA TIDAK KONSISTEN
    // Gunakan hanya dosenStaff() dan lecturerDetail()
    // ============================================================

    public function allMitra()
    {
        $mitras = Cooperation::where('active', 1)
                    ->orderBy('name', 'asc')
                    ->paginate(12);  // <-- ganti get() dengan paginate()
        
        return view('guest.mitra', compact('mitras'));
    }

    public function showMitra($id)
    {
        $mitra = Cooperation::findOrFail($id);
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
        $testi = Testimonial::findOrFail($id);
        return view('guest.testimoni_detail', compact('testi'));
    }

    public function allLabs()
    {
        $labs = Lab::where('active', 1)->get();
        return view('guest.lab_index', compact('labs'));
    }

    public function showLab($id) // Ubah parameter dari $slug menjadi $id
    {
    $lab = Lab::with('tools')->where('id', $id)->where('active', 1)->firstOrFail();
        return view('guest.lab_detail', compact('lab'));
    }

    public function allFacilities()
    {
        $facilities = Facility::where('active', 1)
                    ->orderBy('name', 'asc')
                    ->paginate(12);

        return view('guest.sarana', compact('facilities'));
    }

    public function showFacility($id)
    {
        $facility = Facility::where('active', 1)->findOrFail($id);
        return view('guest.facility_detail', compact('facility'));
    }

    public function beasiswa()
    {
        $data = Profile::where('key', 'A_BEASISWA')
                ->where('active', 1)
                ->firstOrFail();
        return view('guest.beasiswa', compact('data'));
    }

    public function announcements()
{
    $allAnnouncements = Information::announcements()->active()->valid()->latest()->paginate(10);
    
    return view('guest.information', [
        'items' => $allAnnouncements,
        'categories' => ['Pengumuman'],
        'type'  => 'announcement'
    ]);
}

    /**
 * Pencarian global di seluruh konten publik
 */
    public function search(Request $request)
    {
        $query = $request->input('q');
        
        if (empty($query)) {
            return redirect()->back()->with('info', 'Masukkan kata kunci pencarian.');
        }
        
        // Cari di berbagai model
        $results = [];
        
        $news = Information::active()
                    ->where(function($q) use ($query) {
                        $q->where('title', 'LIKE', "%{$query}%")
                        ->orWhere('content', 'LIKE', "%{$query}%");
                    })
                    ->limit(5)
                    ->get();
        
        // 2. Cari Dosen / Staff
        $lecturers = Lecturer::where('active', 1)
                    ->where(function($q) use ($query) {
                        $q->where('name', 'LIKE', "%{$query}%")
                        ->orWhere('nip_nidn', 'LIKE', "%{$query}%")
                        ->orWhere('academic_position', 'LIKE', "%{$query}%");
                    })
                    ->limit(5)
                    ->get();
        if ($lecturers->count()) $results['Dosen / Staff'] = $lecturers;
        
        // 3. Cari Prestasi
        $achievements = Achievement::where('active', 1)
                        ->where(function($q) use ($query) {
                            $q->where('title', 'LIKE', "%{$query}%")
                            ->orWhere('description', 'LIKE', "%{$query}%");
                        })
                        ->limit(5)
                        ->get();
        if ($achievements->count()) $results['Prestasi'] = $achievements;
        
        // 4. Cari Dokumen
        $documents = DocumentArchive::where('active', 1)
                    ->where(function($q) use ($query) {
                        $q->where('title', 'LIKE', "%{$query}%")
                            ->orWhere('description', 'LIKE', "%{$query}%");
                    })
                    ->limit(5)
                    ->get();
        if ($documents->count()) $results['Dokumen'] = $documents;
        
        // 5. Cari Mitra (Cooperation)
        $mitras = Cooperation::where('active', 1)
                ->where('name', 'LIKE', "%{$query}%")
                ->limit(5)
                ->get();
        if ($mitras->count()) $results['Mitra'] = $mitras;
        
        return view('guest.search_results', compact('results', 'query'));
    }

    /**
 * Menampilkan detail berita atau pengumuman (menggunakan model Information)
 */
public function showInformation($id)
{
    // Gunakan model Information, bukan News
    $info = Information::active()->findOrFail($id);

    // Tentukan tipe berdasarkan field 'type' (harus ada di model Information)
    // Jika tidak ada, fallback ke 'news'
    $info->type = $info->type ?? 'news';

    // Jika category kosong, set default
    if (empty($info->category)) {
        $info->category = $info->type == 'news' ? 'Berita' : 'Pengumuman';
    }

    // Attachment file (jika ada di tabel Information)
    $info->attachment_file = $info->attachment_file ?? null;

    // Gunakan view yang sama dengan showNews (konsisten)
    return view('guest.information_detail', compact('info'));
}
    
}