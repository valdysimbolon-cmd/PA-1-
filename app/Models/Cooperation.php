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
        'description', 
        'start_date', 
        'end_date', 
        'active'
    ];
}