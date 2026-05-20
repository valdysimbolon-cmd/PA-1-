<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AchievementRelation extends Model
{
    protected $fillable = ['achievement_id', 'member_id', 'member_type', 'role'];

    // Relasi untuk menarik data Mahasiswa (jika tipenya Student)
    public function student() {
        return $this->belongsTo(Student::class, 'member_id');
    }

    // Relasi untuk menarik data Dosen (jika tipenya Lecturer)
    public function lecturer() {
        return $this->belongsTo(Lecturer::class, 'member_id');
    }
}