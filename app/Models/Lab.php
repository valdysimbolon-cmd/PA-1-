<?php

namespace App\Models;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Lab extends Model {
    use Blameable;
    protected $fillable = ['name', 'staff_id', 'head_of_lab_id', 'category', 'location', 'image', 'active'];

    protected static function boot() {
        parent::boot();
        static::creating(fn($lab) => $mitra->slug = Str::slug($lab->name));
    }

    public function staff() { return $this->belongsTo(User::class, 'staff_id'); }
    public function head() { return $this->belongsTo(Lecturer::class, 'head_of_lab_id'); }
    public function tools() { return $this->hasMany(Tool::class); }
}
