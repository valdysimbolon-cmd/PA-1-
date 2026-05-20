<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Blameable; 

class Profile extends Model
{
    use Blameable; 

    protected $fillable = [
        'key', 
        'name', 
        'description', 
        'image', 
        'active'
    ];

    // Relasi untuk mengetahui siapa Admin pembuatnya
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}