<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lecturer extends Model
{
    use Blameable;

    protected $fillable = [
        'nip_nidn', 'name', 'academic_position', 'academic_level',
        'structural_position', 'parent_id', 'email', 'office',
        'teaching_history', 'image', 'active'
    ];

    // Relasi ke Atasan (Leader)
    public function leader(): BelongsTo
    {
        return $this->belongsTo(Lecturer::class, 'parent_id');
    }

    // Relasi ke Bawahan (Subordinates)
    public function subordinates(): HasMany
    {
        return $this->hasMany(Lecturer::class, 'parent_id')->orderBy('id', 'asc');
    }
    public function educations()
    {
        return $this->hasMany(EducationBackground::class, 'lecturer_id');
    }
}