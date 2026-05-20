<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash; 

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name'     => 'Super Admin Bioproses',
            'email'    => 'admin@del.ac.id',
            'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
            'role'     => 'super_admin',
            'status'   => 'Aktif',
        ]);
    }
}