<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EducationBackground extends Model
{
    protected $fillable = [
        'lecturer_id',
        'degree',
        'campus',
        'study_program',
        'graduation_year',
    ];

    protected $casts = [
        'graduation_year' => 'integer',
    ];

    public function lecturer(): BelongsTo
    {
        return $this->belongsTo(Lecturer::class);
    }
}