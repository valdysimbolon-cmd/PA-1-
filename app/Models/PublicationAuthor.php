<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublicationAuthor extends Model
{
    protected $fillable = ['publication_id', 'author_id', 'author_type', 'position'];

    // TAMBAHKAN RELASI INI (Agar tidak error 500 lagi)
    public function publication()
    {
        return $this->belongsTo(Publication::class, 'publication_id');
    }

    // Relasi ke Dosen
    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class, 'author_id');
        
    }
}