<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;

class Cooperation extends Model
{
    use Blameable;

protected $fillable = ['name', 'type', 'logo', 'start_date', 'end_date', 'description', 'active', 'created_by', 'updated_by'];
}