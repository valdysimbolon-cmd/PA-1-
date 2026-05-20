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
        'website_url', 
        'start_date', 
        'end_date', 
        'active'
    ];
}