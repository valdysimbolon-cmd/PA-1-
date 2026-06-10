<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AchievementRelation extends Model
{
    protected $fillable = [
        'achievement_id',
        'member_id',
        'member_type',
        'role'
    ];

    public function achievement(): BelongsTo
    {
        return $this->belongsTo(Achievement::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'member_id');
    }

    public function lecturer(): BelongsTo
    {
        return $this->belongsTo(Lecturer::class, 'member_id');
    }

    /**
     * Helper untuk tampilan
     */
    public function getPersonAttribute()
    {
        return $this->member_type === 'Lecturer'
            ? $this->lecturer
            : $this->student;
    }
}