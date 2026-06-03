<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model {
    protected $fillable = [
        'code', 'name', 'sks', 'semester', 'description', 
        'curriculum_id', 'active', 'created_by', 'updated_by'
    ];

    public function curriculum() {
        return $this->belongsTo(Curriculum::class);
    }
}