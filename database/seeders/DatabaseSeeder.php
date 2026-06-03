<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

    // Pastikan sudah ada user admin denga ID 1
    $categories = [
        'Kegiatan Mahasiswa',
        'Kegiatan Dosen',
        'Prestasi Mahasiswa',
        'Prestasi Dosen',
        'Umum'
    ];

    foreach ($categories as $cat) {
        \App\Models\NewsCategory::updateOrCreate(
            ['name' => $cat],
            ['active' => 1, 'created_by' => 1] // Sesuaikan created_by denga ID Admin
        );
    }

        // Menciptakan Super Admin pertama untuk akses penuh
        User::create([
            'name' => 'Super Admin Bioproses',
            'email' => 'admin@del.ac.id',
            'password' => Hash::make('admin123'), // Password terenkripsi
            'role' => 'super_admin',
            'status' => 'Aktif',
        ]);

        // Opsional: Menciptakan Admin Lab untuk testing
        User::create([
            'name' => 'Staf Laboratorium',
            'email' => 'adminlab@del.ac.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin_lab',
            'status' => 'Aktif',
        ]);
        
        $this->command->info('Berhasil membuat akun Admin dan Staf Lab!');
    }
}
