<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;

class Cooperation extends Model
{
    use Blameable;

    protected $fillable = [
        'name',
        'type',
        'logo',
        'start_date',
        'end_date',
        'description',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}