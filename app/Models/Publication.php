<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publication extends Model {
    protected $fillable = ['title', 'type', 'publisher', 'year', 'link', 'active'];

    // Relasi ke tabel Jembatan Penulis
    public function authors() {
        return $this->hasMany(PublicationAuthor::class);
    }
}
