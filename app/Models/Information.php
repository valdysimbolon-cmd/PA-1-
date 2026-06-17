<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Information extends Model
{
    use Blameable;

    // Nama tabel secara eksplisit
    protected $table = 'informations';

    protected $fillable = [
        'type',
        'title',
        'content',
        'image',
        'active',
        'category',
        'published_at',
        'attachment_file',
        'is_important',
        'expired_at',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'expired_at'   => 'datetime',
        'active'       => 'boolean',
        'is_important' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | SCOPES (Fungsi Bantuan untuk Query)
    |--------------------------------------------------------------------------
    | Cara pakai di Controller: 
    | Information::news()->get(); 
    | Information::announcements()->active()->get();
    */

    /**
     * Mengambil hanya data Berita & Kegiatan
     */
    public function scopeNews(Builder $query)
    {
        return $query->where('type', 'news');
    }

    /**
     * Mengambil hanya data Pengumuman
     */
    public function scopeAnnouncements(Builder $query)
    {
        return $query->where('type', 'announcement');
    }

    /**
     * Mengambil data yang statusnya Aktif
     */
    public function scopeActive(Builder $query)
    {
        return $query->where('active', true);
    }

    /**
     * Mengambil Pengumuman yang belum kedaluwarsa
     */
    public function scopeValid(Builder $query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expired_at')
              ->orWhere('expired_at', '>=', Carbon::now());
        });
    }

    /**
     * Mengambil Pengumuman Penting (is_important = true)
     */
    public function scopeImportant(Builder $query)
    {
        return $query->where('is_important', true);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    /**
     * Cek apakah informasi ini memiliki lampiran dokumen
     */
    public function hasAttachment(): bool
    {
        return !empty($this->attachment_file);
    }
}