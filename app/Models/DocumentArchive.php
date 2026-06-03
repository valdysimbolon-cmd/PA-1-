<?php

namespace App\Models;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;

class DocumentArchive extends Model {
    protected $fillable = ['title', 'category', 'file_path', 'year', 'description', 'active', 'created_by', 'updated_by'];
}