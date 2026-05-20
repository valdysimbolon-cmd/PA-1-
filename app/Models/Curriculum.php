<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; 
use Illuminate\Database\Eloquent\Relations\HasMany;

class Curriculum extends Model
{
    use Blameable;
    protected $table = 'curriculums';
    protected $fillable = ['name', 'active'];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
}
