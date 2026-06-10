<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\NewsCategory;
use App\Models\News;
use App\Models\Hero;
use App\Models\Lab;
use App\Models\Announcement;
use App\Models\Testimonial;
use App\Models\Cooperation;
use App\Models\Achievement;
use App\Models\Student;
use App\Models\Profile;
use App\Models\Facility;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. KONTEN USER & ADMIN
        $admin = User::updateOrCreate(
            ['email' => 'admin@del.ac.id'],
            [
                'name' => 'Super Admin Bioproses',
                'password' => Hash::make('admin123'),
                'role' => 'super_admin',
                'status' => 'Aktif',
            ]
        );

        User::updateOrCreate(
            ['email' => 'mahasiswa@del.ac.id'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('mahasiswa123'),
                'role' => 'mahasiswa',
                'status' => 'Aktif',
            ]
        );

        // 2. KONTEN KATEGORI
        $categories = [
            'Kegiatan Mahasiswa', 'Kegiatan Dosen', 'Prestasi Mahasiswa', 
            'Prestasi Dosen', 'Umum', 'Reminder', 'Akademik', 
            'Kemahasiswaan', 'Informasi Fakultas', 'Beasiswa / Lowongan'
        ];

        foreach ($categories as $cat) {
            NewsCategory::updateOrCreate(
                ['name' => $cat],
                ['active' => 1, 'created_by' => $admin->id]
            );
        }

        $catMhs = NewsCategory::where('name', 'Kegiatan Mahasiswa')->first()->id;
        $catUmum = NewsCategory::where('name', 'Umum')->first()->id;

// 3. KONTEN HERO BERANDA (Dibuat seminimal mungkin biar lolos eror kolom)
        \App\Models\Hero::create([
            'title' => 'Selamat Datang di Teknik Bioproses IT Del',
            'subtitle' => 'Mengembangkan Teknologi Berbasis Hayati untuk Masa Depan.',
            'active' => 1
        ]);

        // 4. KONTEN BERITA (Biar section Berita & Kegiatan langsung terisi penuh padat)
        for ($i = 1; $i <= 6; $i++) {
            News::create([
                'title' => "Kunjungan Ilmiah dan Riset Kolaborasi Mahasiswa Bioproses Seri ke-$i",
                'slug' => "kunjungan-ilmiah-dan-riset-kolaborasi-mahasiswa-bioproses-seri-ke-$i",
                'content' => "Ini adalah simulasi konten berita resmi untuk pameran Program Studi Teknik Bioproses Institut Teknologi Del.",
                'category_id' => $catMhs,
                'thumbnail' => '', 
                'active' => 1,
                'published_at' => now(),
                'created_by' => $admin->id
            ]);
        }

        // 5. KONTEN PENGUMUMAN (Biar teks 'Belum ada pengumuman terbaru' hilang)
        for ($i = 1; $i <= 5; $i++) {
            Announcement::create([
                'title' => "[PENTING] Pengumuman Pelaksanaan Praktikum Laboratorium Gelombang $i",
                'content' => "Diberitahukan kepada seluruh mahasiswa Teknik Bioproses untuk mengikuti modul praktikum secara berkala.",
                'category_id' => $catUmum,
                'active' => 1,
                'created_by' => $admin->id
            ]);
        }

        // 6. KONTEN PENDUKUNG (Visi Misi, Lab, Fasilitas, Mitra)
        Profile::create(['key' => 'B_VISI', 'value' => 'Menjadi Program Studi Teknik Bioproses yang unggul secara nasional.', 'active' => 1]);
        Profile::create(['key' => 'B_MISI', 'value' => 'Menyelenggarakan pendidikan rekayasa hayati berkualitas tinggi.', 'active' => 1]);
        Profile::create(['key' => 'A_BEASISWA', 'value' => 'Beasiswa Prestasi Internal IT Del.', 'active' => 1]);

        Lab::create(['name' => 'Laboratorium Mikrobiologi Dasar', 'slug' => 'laboratorium-mikrobiologi-dasar', 'description' => 'Fasilitas kultur sel.', 'active' => 1]);
        Lab::create(['name' => 'Laboratorium Bioproses & Fermentasi', 'slug' => 'laboratorium-bioproses-fermentasi', 'description' => 'Skala bioreaktor pilot.', 'active' => 1]);

        Cooperation::create(['name' => 'PT Bio Farma', 'logo' => '', 'active' => 1]);
        Cooperation::create(['name' => 'BRIN Indonesia', 'logo' => '', 'active' => 1]);

        Facility::create(['name' => 'Ruang Kuliah Teater', 'description' => 'Kapasitas 100 mahasiswa', 'active' => 1]);
        Student::create(['name' => 'Mahasiswa Dummy', 'nim' => '12S21001', 'active' => 1]);

        $this->command->info('DATABASE SIAP TEMPUR UNTUK PAMERAN!');
    }
}