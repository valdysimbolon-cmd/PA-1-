<?php

namespace App\Models;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;

class DocumentArchive extends Model {
    use Blameable;
    protected $fillable = ['title', 'category', 'file_path', 'year', 'active'];
}