<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Lab extends Model
{
    // -------------------------------------------------------------------------
    // Konfigurasi
    // -------------------------------------------------------------------------

    protected $fillable = [
        'name',
        'category',
        'location',
        'image',
        'description',
        'active',
        'staff_id',
        'head_of_lab_id',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Kategori lab yang valid — sinkron dengan migration.
     */
    public const CATEGORIES = ['Praktikum', 'Riset', 'Umum'];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    public function head(): BelongsTo
    {
        return $this->belongsTo(Lecturer::class, 'head_of_lab_id');
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function tools(): HasMany
    {
         return $this->hasMany(Tool::class, 'lab_id');
    }

    // -------------------------------------------------------------------------
    // Scopes
    // -------------------------------------------------------------------------

    /**
     * Hanya lab yang aktif.
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Filter berdasarkan kategori.
     */
    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    // -------------------------------------------------------------------------
    // Accessors
    // -------------------------------------------------------------------------

    /**
     * URL publik image lab.
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image
            ? Storage::disk('public')->url($this->image)
            : null;
    }

    /**
     * Cek apakah lab punya image.
     */
    public function hasImage(): bool
    {
        return ! empty($this->image)
            && Storage::disk('public')->exists($this->image);
    }
}