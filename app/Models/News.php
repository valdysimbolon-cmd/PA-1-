<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class News extends Model
{
    protected $fillable = [
        'title',
        'content',
        'image',
        'published_at',
        'category_id',
        'created_by',
        'updated_by',
        'active'
    ];

    protected $casts = [
        'published_at' => 'date',
        'active' => 'boolean',
    ];

    /**
     * Relasi ke kategori berita
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(NewsCategory::class, 'category_id');
    }

    /**
     * Admin yang membuat berita
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Admin yang terakhir mengubah berita
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}