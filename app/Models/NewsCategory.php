<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NewsCategory extends Model
{
    protected $fillable = ['name', 'active', 'created_by', 'updated_by'];

    public function news(): HasMany
    {
        return $this->hasMany(News::class, 'category_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}