<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Curriculum extends Model
{
    protected $table = 'curriculums';

    protected $fillable = [
        'name',
        'active',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Relasi ke Mata Kuliah
     */
    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class, 'curriculum_id');
    }

    /**
     * Admin yang membuat
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Admin yang terakhir mengubah
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}