<?php

namespace App\Models;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Facility extends Model {
    use Blameable;
    protected $fillable = ['name', 'type', 'capacity', 'location', 'description', 'image', 'active'];
}
