<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Achievement extends Model
{
    use Blameable;

    protected $fillable = [
        'category',
        'winner_name',
        'title',
        'description',
        'rank',
        'level',
        'year',
        'image',
        'active',
        'created_by',
        'updated_by'
    ];

    /**
     * Semua anggota yang terlibat
     */
    public function members(): HasMany
    {
        return $this->hasMany(AchievementRelation::class);
    }

    /**
     * Dosen yang terlibat
     */
    public function lecturers(): BelongsToMany
    {
        return $this->belongsToMany(
            Lecturer::class,
            'achievement_relations',
            'achievement_id',
            'member_id'
        )
        ->wherePivot('member_type', 'Lecturer')
        ->withPivot('role');
    }

    /**
     * Mahasiswa yang terlibat
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(
            Student::class,
            'achievement_relations',
            'achievement_id',
            'member_id'
        )
        ->wherePivot('member_type', 'Student')
        ->withPivot('role');
    }
}