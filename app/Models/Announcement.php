<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Announcement extends Model
{
    use Blameable;

    protected $fillable = [
        'title', 'content', 'category_id', 'attachment_file', 
        'expired_at', 'active', 'is_urgent', 'created_by', 'updated_by'
    ];

    // 2. Sesuaikan Casting (is_urgent hanya ditambah jika ada di migration)
    protected $casts = [
        'expired_at' => 'date',
        'active'     => 'boolean',
    ];

    // 3. SEBAIKNYA: Tambahkan "Scope" agar Controller memanggilnya lebih mudah
    // Hanya mengambil pengumuman yang aktif dan belum kadaluarsa
    public function scopeActiveAndValid(Builder $query)
    {
        return $query->where('active', 1)
                     ->where(function ($q) {
                         $q->whereNull('expired_at')
                           ->orWhere('expired_at', '>=', Carbon::today());
                     });
    }

    // 4. SEBAIKNYA: Helper untuk mengecek apakah ada lampiran
    public function hasAttachment()
    {
        return !empty($this->attachment_file);
    }

    public function category()
    {
        return $this->belongsTo(NewsCategory::class, 'category_id');
    }
}