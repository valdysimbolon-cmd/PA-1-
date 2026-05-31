<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Blameable; 
class Tool extends Model {
    use Blameable;
    protected $fillable = ['lab_id', 'code', 'name', 'specification', 'condition', 'stock_total', 'unit', 'is_borrowable', 'image', 'active'];
    
    public function lab() { return $this->belongsTo(Lab::class); }
}
