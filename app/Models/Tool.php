<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Blameable; 
class Tool extends Model {
    
    use Blameable;
    protected $fillable = ['lab_id', 'code', 'name', 'spesification', 'condition', 'stock_total', 'unit', 'image', 'description','is_borrowable', 'created_by', 'updated_by', 'active'];

    public function lab() {
        return $this->belongsTo(Lab::class);
    }
}
