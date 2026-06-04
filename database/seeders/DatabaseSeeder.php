<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\NewsCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. BUAT USER ADMIN DULU (Sangat Penting agar ID 1 tersedia)
        // Menggunakan updateOrCreate agar tidak error Duplicate Entry saat dijalankan ulang
        $admin = User::updateOrCreate(
            ['email' => 'admin@del.ac.id'], // Cek berdasarkan email
            [
                'name' => 'Super Admin Bioproses',
                'password' => Hash::make('admin123'),
                'role' => 'super_admin',
                'status' => 'Aktif',
            ]
        );

        // Buat Admin Lab untuk testing
        User::updateOrCreate(
            ['email' => 'adminlab@del.ac.id'],
            [
                'name' => 'Staf Laboratorium',
                'password' => Hash::make('admin123'),
                'role' => 'admin_lab',
                'status' => 'Aktif',
            ]
        );

        // 2. ISI KATEGORI (BERITA & PENGUMUMAN)
        $categories = [
            'Kegiatan Mahasiswa',
            'Kegiatan Dosen',
            'Prestasi Mahasiswa',
            'Prestasi Dosen',
            'Umum',
            'Reminder',
            'Akademik',
            'Kemahasiswaan',
            'Informasi Fakultas',
            'Beasiswa / Lowongan'
        ];

        foreach ($categories as $cat) {
            NewsCategory::updateOrCreate(
                ['name' => $cat], // Cek berdasarkan nama kategori
                [
                    'active' => 1, 
                    'created_by' => $admin->id // Menggunakan ID admin yang baru dibuat di atas
                ]
            );
        }

        $this->command->info('Berhasil membuat akun Admin dan seluruh Kategori!');
    }
}