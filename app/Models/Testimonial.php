<?php

namespace App\Models;

use App\Traits\Blameable; // Pastikan Trait ini sudah kamu buat sebelumnya
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use Blameable;
    protected $fillable = ['name', 'batch', 'position', 'content', 'photo', 'active', 'created_by', 'updated_by'];
}
