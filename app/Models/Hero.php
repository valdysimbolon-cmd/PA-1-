<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Hero extends Model
{
    // -------------------------------------------------------------------------
    // Konfigurasi
    // -------------------------------------------------------------------------

    protected $fillable = [
        'title',
        'subtitle',
        'video_url',
        'primary_button_text',
        'primary_button_url',
        'secondary_button_text',
        'secondary_button_url',
        'active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    // -------------------------------------------------------------------------
    // Model Events — Menjaga Hanya Satu Hero Aktif (Lapisan Tambahan)
    // -------------------------------------------------------------------------

    /**
     * Bootstrap model events.
     * Setiap kali hero disimpan, pastikan hanya satu yang aktif.
     */
    protected static function booted()
    {
        static::saving(function ($hero) {
            // Jika hero ini diaktifkan, nonaktifkan semua hero lain yang aktif
            if ($hero->active) {
                static::where('id', '!=', $hero->id)
                    ->where('active', true)
                    ->update(['active' => false]);
            }
        });
    }

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // -------------------------------------------------------------------------
    // Scopes
    // -------------------------------------------------------------------------

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    // -------------------------------------------------------------------------
    // Accessors — YouTube
    // -------------------------------------------------------------------------

    /**
     * Ekstrak video ID dari berbagai format URL YouTube:
     * - youtube.com/watch?v=xxxxx
     * - youtu.be/xxxxx
     * - youtube.com/embed/xxxxx
     */
    public function getVideoIdAttribute(): ?string
    {
        if (! $this->video_url) {
            return null;
        }

        preg_match(
            '/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([^&\n?#]+)/',
            $this->video_url,
            $matches
        );

        return $matches[1] ?? null;
    }

    /**
     * URL embed YouTube siap pakai sebagai background:
     * autoplay + mute (wajib agar autoplay jalan di browser)
     * loop + playlist (wajib agar loop bekerja)
     * controls=0, rel=0 untuk tampilan bersih
     */
    public function getEmbedUrlAttribute(): ?string
    {
        if (! $this->video_id) {
            return null;
        }

        return "https://www.youtube.com/embed/{$this->video_id}"
            . "?autoplay=1"
            . "&mute=1"
            . "&loop=1"
            . "&playlist={$this->video_id}"
            . "&controls=0"
            . "&rel=0"
            . "&modestbranding=1"
            . "&vq=hd1080"
            . "&enablejsapi=1";
    }

    /**
     * Cek apakah hero punya video YouTube valid.
     */
    public function hasVideo(): bool
    {
        return ! empty($this->video_id);
    }
}