<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EducationBackground extends Model
{
    protected $fillable = ['lecturer_id', 'campus', 'study_program', 'degree', 'graduation_year'];

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class);
    }
}
