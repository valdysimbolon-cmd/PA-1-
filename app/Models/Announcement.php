<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use Blameable;

    protected $fillable = [
        'title', 'content', 'attachment_file', 'is_urgent', 'expired_at', 'active'
    ];

    // Casting agar tanggal expired otomatis jadi objek Carbon (Waktu PHP)
    protected $casts = [
        'expired_at' => 'date',
        'is_urgent' => 'boolean'
    ];
}