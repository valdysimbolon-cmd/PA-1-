<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class DocumentArchive extends Model
{
    // -------------------------------------------------------------------------
    // Konfigurasi
    // -------------------------------------------------------------------------

    protected $fillable = [
        'title',
        'tags',
        'file_path',
        'year',
        'description',
        'active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tags'   => 'array',    // JSON ["SOP","Pedoman"] <-> PHP array otomatis
        'active' => 'boolean',
        'year'   => 'integer',
    ];

    /**
     * Tag preset yang tersedia.
     * Dijadikan konstanta agar sinkron antara model, controller, dan blade.
     */
    public const PRESET_TAGS = [
        'Pedoman',
        'SOP',
        'Formulir',
    ];

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

    /**
     * Hanya dokumen yang aktif.
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Filter dokumen yang mengandung tag tertentu.
     * Menggunakan whereJsonContains — didukung MySQL & PostgreSQL.
     */
    public function scopeByTag($query, string $tag)
    {
        return $query->whereJsonContains('tags', $tag);
    }

    /**
     * Filter berdasarkan tahun.
     */
    public function scopeByYear($query, int $year)
    {
        return $query->where('year', $year);
    }

    // -------------------------------------------------------------------------
    // Accessors
    // -------------------------------------------------------------------------

    /**
     * URL publik file — digunakan di blade untuk link unduh.
     */
    public function getFileUrlAttribute(): ?string
    {
        return $this->file_path
            ? Storage::disk('public')->url($this->file_path)
            : null;
    }

    /**
     * Ekstensi file (pdf, docx, xlsx) — digunakan untuk tampilkan ikon.
     */
    public function getFileExtensionAttribute(): ?string
    {
        return $this->file_path
            ? strtolower(pathinfo($this->file_path, PATHINFO_EXTENSION))
            : null;
    }

    /**
     * Apakah dokumen punya file yang bisa diunduh.
     */
    public function hasFile(): bool
    {
        return ! empty($this->file_path)
            && Storage::disk('public')->exists($this->file_path);
    }

    // -------------------------------------------------------------------------
    // Access Control
    // -------------------------------------------------------------------------

    /**
     * Cek apakah user boleh mengunduh dokumen ini.
     * Guest (null) → tidak boleh.
     * Mahasiswa, peminjam, admin → boleh.
     */
    public function canBeDownloadedBy(?User $user): bool
    {
        if (! $user) return false;

        return in_array($user->role, ['mahasiswa', 'peminjam', 'admin']);
    }
}