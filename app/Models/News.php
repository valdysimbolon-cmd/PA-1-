<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use Blameable;

    // Hanya kolom yang ada di database
    protected $fillable = [
        'category_id', 
        'title', 
        'content', 
        'image', 
        'published_at', 
        'active'
    ];

    // Relasi ke Kategori
    public function category()
    {
        return $this->belongsTo(NewsCategory::class, 'category_id');
    }

    // Relasi ke User (Penulis)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}