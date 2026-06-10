<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Blameable;
use App\Models\User;

class Profile extends Model
{
    use Blameable;

    protected $fillable = [
        'key',
        'name',
        'description',
        'image',
        'active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // OPTIONAL CLEAN UI LOGIC
    public function getPlacementAttribute()
    {
        if (str_starts_with($this->key, 'B_')) return 'Beranda';
        if (str_starts_with($this->key, 'P_')) return 'Profil';
        return 'Lainnya';
    }
}