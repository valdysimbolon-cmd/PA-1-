<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model
{
    use Blameable;
    protected $fillable = ['name', 'active'];

    // Relasi: Satu Kategori punya BANYAK Berita
    public function news() {
        return $this->hasMany(News::class, 'category_id');
    }
}
