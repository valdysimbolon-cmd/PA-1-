<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Achievement extends Model
{
    use Blameable;

    protected $fillable = ['category', 'winner_name', 'level', 'title', 'rank', 'year', 'image', 'active'];

    // Relasi ke Jembatan Pemenang
    public function members(): HasMany
    {
        return $this->hasMany(AchievementRelation::class, 'achievement_id');
    }
}