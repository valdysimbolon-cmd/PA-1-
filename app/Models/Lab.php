<?php

namespace App\Models;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Lab extends Model
{
    protected $fillable = [
        'name', 'slug', 'head_of_lab_id', 'staff_id', 
        'category', 'location', 'image', 
        'description', // Kolom untuk isi CKEditor
        'active', 'created_by', 'updated_by'
    ];

    public function head() {
        return $this->belongsTo(Lecturer::class, 'head_of_lab_id');
    }

    public function staff() {
        return $this->belongsTo(User::class, 'staff_id');
    }
    
    public function tools() {
        return $this->hasMany(Tool::class);
    }
}