<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    // Jika nama tabel Anda di database bukan 'students', tentukan di sini:
    // protected $table = 'nama_tabel_mahasiswa_anda';

    protected $fillable = ['name', 'nim', 'active']; 
}