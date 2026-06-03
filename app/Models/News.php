<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class News extends Model
{
    protected $fillable = [
        'title', 'content', 'image', 'published_at', 
        'category_id', 'created_by', 'updated_by', 'active'
    ];

    // Hubungkan ke Kategori
    public function category(): BelongsTo
    {
        return $this->belongsTo(NewsCategory::class, 'category_id');
    }

    // Hubungkan ke Admin yang membuat
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}