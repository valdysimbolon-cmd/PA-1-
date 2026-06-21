<?php

namespace App\Models;

use App\Models\Inventory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LabLoanDetail extends Model
{
    protected $table = 'lab_loan_details';

    protected $fillable = [
        'lab_loan_id', 'inventory_id', 'quantity', 'notes',
    ];

    public function labLoan(): BelongsTo
    {
        return $this->belongsTo(LabLoan::class, 'lab_loan_id');
    }

    /**
     * Relasi ke inventory — TANPA withDefault()
     * Gunakan null check di blade: $d->inventory?->item_name ?? '[Item Dihapus]'
     */
    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }
}