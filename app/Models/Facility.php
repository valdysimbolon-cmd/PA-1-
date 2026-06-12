<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Facility extends Model
{
    use Blameable;

    protected $fillable = [
        'name',
        'type',
        'capacity',
        'location',
        'description',
        'image',
        'created_by',
        'updated_by',
        'active',
    ];

    protected $casts = [
        'capacity' => 'integer',
        'active' => 'boolean',
    ];

    /**
     * Scope hanya fasilitas aktif
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }

    /**
     * Cek apakah fasilitas memiliki gambar
     */
    public function hasImage(): bool
    {
        return !empty($this->image);
    }

    /**
     * Relasi pembuat data
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relasi pengubah terakhir
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}