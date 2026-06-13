<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use Blameable;

    protected $fillable = [
        'category',
        'title',
        'content',
        'image',
        'published_at',
        'active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'published_at' => 'date',
        'active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}