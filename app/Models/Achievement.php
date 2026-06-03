<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Achievement extends Model {
    protected $fillable = ['category', 'winner_name', 'title', 'rank', 'level', 'year', 'image', 'active', 'created_by', 'updated_by'];

    // Relasi ke tabel jembatan (untuk ambil daftar nama anggota)
    public function members() {
        return $this->hasMany(AchievementRelation::class);
    }

    public function lecturers()
    {
        return $this->belongsToMany(Lecturer::class, 'achievement_relations', 'achievement_id', 'member_id')
                    ->wherePivot('member_type', 'Lecturer');
    }
}