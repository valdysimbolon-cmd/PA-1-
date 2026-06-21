<?php

namespace App\Http\Controllers\Guest\Beranda;

use Illuminate\Http\Request;
use App\Models\Information;
use App\Models\Lecturer;     
use App\Models\Achievement;
use App\Models\DocumentArchive; 
use App\Models\Cooperation;    
use App\Models\Facility;
use App\Models\Lab;
use App\Models\Profile;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        // Menangkap input 'query' dari navbar
        $query = $request->input('query');
        $results = [];

        if ($query) {
            // 1. Cari di Berita (Judul & Konten)
        $news = Information::news()
                    ->where(function($q) use ($query) {
                        $q->where('title', 'LIKE', "%{$query}%")
                        ->orWhere('content', 'LIKE', "%{$query}%");
                    })
                    ->get();
            if ($news->isNotEmpty()) $results['Berita'] = $news;

            // 2. Cari di Pengumuman (Judul & Konten)
        $announcements = Information::announcements()
                            ->where(function($q) use ($query) {
                                $q->where('title', 'LIKE', "%{$query}%")
                                ->orWhere('content', 'LIKE', "%{$query}%");
                            })
                            ->get();

            // 3. Cari di Dosen & Staff (Nama & Jabatan Akademik)
            $lecturers = Lecturer::where('name', 'LIKE', "%{$query}%")
                                 ->orWhere('academic_position', 'LIKE', "%{$query}%")
                                 ->get();
            if ($lecturers->isNotEmpty()) $results['Dosen & Staff'] = $lecturers;

            // 4. Cari di Fasilitas & Lab (Nama & Deskripsi)
            $facilities = Facility::where('name', 'LIKE', "%{$query}%")
                                  ->orWhere('description', 'LIKE', "%{$query}%")
                                  ->get();
            $labs = Lab::where('name', 'LIKE', "%{$query}%")
                       ->orWhere('description', 'LIKE', "%{$query}%")
                       ->get();
            
            if ($facilities->isNotEmpty() || $labs->isNotEmpty()) {
                $results['Fasilitas & Lab'] = $facilities->concat($labs);
            }

            // 5. Cari di Kerjasama / Mitra (Nama & Deskripsi)
            $partners = Cooperation::where('name', 'LIKE', "%{$query}%")
                                   ->orWhere('description', 'LIKE', "%{$query}%")
                                   ->get();
            if ($partners->isNotEmpty()) $results['Mitra Strategis'] = $partners;

            // 6. Cari di Prestasi (Judul & Deskripsi)
            $achievements = Achievement::where('title', 'LIKE', "%{$query}%")
                                       ->orWhere('description', 'LIKE', "%{$query}%")
                                       ->get();
            if ($achievements->isNotEmpty()) $results['Prestasi'] = $achievements;

            // 7. Cari di Arsip Dokumen (Judul & Deskripsi)
            $documents = DocumentArchive::where('title', 'LIKE', "%{$query}%")
                                        ->orWhere('description', 'LIKE', "%{$query}%")
                                        ->get();
            if ($documents->isNotEmpty()) $results['Dokumen'] = $documents;

            // 8. Cari di Profil Prodi (Nama & Deskripsi - Tempat info Akreditasi biasanya ada)
            $profiles = Profile::where('name', 'LIKE', "%{$query}%")
                               ->orWhere('description', 'LIKE', "%{$query}%")
                               ->get();
            if ($profiles->isNotEmpty()) $results['Profil Prodi'] = $profiles;
        }

        // Mengarah ke views/guest/search.blade.php
        return view('guest.search', compact('results', 'query'));
    }
}