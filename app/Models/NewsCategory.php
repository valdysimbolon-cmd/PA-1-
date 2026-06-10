<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class NewsCategory extends Model
{
    protected $fillable = [
        'name',
        'active',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Relasi ke berita
     */
    public function news(): HasMany
    {
        return $this->hasMany(News::class, 'category_id');
    }

    /**
     * Admin yang membuat kategori
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Admin yang terakhir mengubah kategori
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}