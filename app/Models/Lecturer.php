<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Lecturer extends Model
{
    use Blameable;

    protected $fillable = [
        'nip_nidn',
        'name',
        'email',
        'image',

        'academic_position',
        'academic_level',

        'structural_position',
        'parent_id',

        'office',
        'teaching_history',

        'sinta_url',
        'pddikti_url',

        'active',

        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Struktur Organisasi
    |--------------------------------------------------------------------------
    */

    public function leader(): BelongsTo
    {
        return $this->belongsTo(Lecturer::class, 'parent_id');
    }

    public function subordinates(): HasMany
    {
        return $this->hasMany(Lecturer::class, 'parent_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Riwayat Pendidikan
    |--------------------------------------------------------------------------
    */

    public function educations(): HasMany
    {
        return $this->hasMany(EducationBackground::class)
                    ->orderBy('graduation_year');
    }

    /*
    |--------------------------------------------------------------------------
    | Publikasi
    |--------------------------------------------------------------------------
    */

    public function publications(): HasMany
    {
        return $this->hasMany(PublicationAuthor::class, 'author_id')
                    ->where('author_type', self::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Prestasi
    |--------------------------------------------------------------------------
    */

    public function achievements(): BelongsToMany
    {
        return $this->belongsToMany(
                Achievement::class,
                'achievement_relations',
                'member_id',
                'achievement_id'
            )
            ->wherePivot('member_type', 'Lecturer')
            ->withPivot('role');
    }
}