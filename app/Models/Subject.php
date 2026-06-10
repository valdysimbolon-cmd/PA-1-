<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subject extends Model
{
    protected $fillable = [
        'code',
        'name',
        'sks',
        'semester',
        'description',
        'curriculum_id',
        'active',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'active' => 'boolean',
        'sks' => 'integer',
    ];

    /**
     * Relasi ke Kurikulum
     */
    public function curriculum(): BelongsTo
    {
        return $this->belongsTo(Curriculum::class, 'curriculum_id');
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