<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lecturer extends Model
{
    use Blameable;

protected $fillable = [
    'nip_nidn', 'name', 'academic_position', 'academic_level',
    'structural_position', 'parent_id', 'email', 'office',
    'teaching_history', 'image', 'active', 
    'sinta_url', 'pddikti_url', // TAMBAHKAN DUA BARIS INI
    'created_by', 'updated_by'
];

    // Relasi ke Atasan (Leader)
    public function leader(): BelongsTo
    {
        return $this->belongsTo(Lecturer::class, 'parent_id');
    }

    public function educations() {
        return $this->hasMany(EducationBackground::class, 'lecturer_id');
    }

    public function publications() {
        // Relasi ke tabel jembatan penulis
        return $this->hasMany(PublicationAuthor::class, 'author_id')->where('author_type', 'App\Models\Lecturer');
    }

    public function achievements()
    {
        // Kita hubungkan ke Achievement lewat tabel achievement_relations
        return $this->belongsToMany(Achievement::class, 'achievement_relations', 'member_id', 'achievement_id')
                    ->wherePivot('member_type', 'Lecturer') // Pastikan hanya mengambil tipe Lecturer
                    ->withPivot('role') // Ambil data role (Ketua/Anggota/Pembimbing) jika perlu
                    ->where('active', 1);
    }
}