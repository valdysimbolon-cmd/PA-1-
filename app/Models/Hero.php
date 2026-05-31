<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    use Blameable;

    // Daftarkan semua kolom agar bisa diisi (Mass Assignment)
    protected $fillable = [
        'title', 
        'subtitle', 
        'video_url', 
        'poster_image', 
        'button_1_text', 
        'button_1_url', 
        'button_2_text', 
        'button_2_url', 
        'active'
    ];
}