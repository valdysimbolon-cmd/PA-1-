<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Hero;
use App\Models\NewsCategory;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Jalankan UserSeeder dulu untuk membuat akun admin
        $this->call([
            UserSeeder::class,
        ]);

        // 2. Ambil data admin yang baru saja dibuat
        $admin = User::where('email', 'admin@del.ac.id')->first();

        // 3. Buat Hero dengan menyertakan 'created_by'
        Hero::updateOrCreate(
            ['id' => 1],
            [
                'title'      => 'Selamat Datang di Teknik Bioproses',
                'subtitle'   => 'Mengembangkan Teknologi Berbasis Hayati.',
                'video_url'  => '', 
                'active'     => 1,
                'created_by' => $admin->id, // INI PERBAIKANNYA
            ]
        );

        // 4. Buat Kategori (Jika di tabel kategori juga ada created_by, tambahkan juga)
        $categories = ['Kegiatan', 'Prestasi', 'Akademik', 'Pengumuman'];
        foreach ($categories as $cat) {
            NewsCategory::updateOrCreate(
                ['name' => $cat],
                [
                    'active'     => 1, 
                    'created_by' => $admin->id // Tambahkan juga di sini jika perlu
                ]
            );
        }

        // Di dalam function run() DatabaseSeeder.php

// 1. Ambil ID admin dulu (seperti sebelumnya)
$admin = \App\Models\User::where('email', 'admin@del.ac.id')->first();

// 2. Buat data Kurikulum dasar
\App\Models\Curriculum::updateOrCreate(
    ['id' => 1],
    [
        'name' => 'Kurikulum Proyeksi 2024-2028',
        'active' => 1,
        'created_by' => $admin->id
    ]
);

        $this->command->info('Database berhasil di-seed tanpa error!');
    }
}