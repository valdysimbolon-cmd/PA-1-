<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash; 

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@del.ac.id'],
            [
                'name'     => 'Super Admin Bioproses',
                'password' => Hash::make('admin123'),
                'role'     => 'super_admin',
                'status'   => 'Aktif',
            ]
        );
    }
}