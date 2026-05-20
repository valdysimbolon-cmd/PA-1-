<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use Blameable;

    protected $fillable = [
        'curriculum_id', 'code', 'name', 'sks', 'semester', 'description', 'active'
    ];
    
    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }
}