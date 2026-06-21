<?php

namespace App\Models;

use App\Models\LabLoanDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Inventory extends Model
{
    protected $table = 'inventory';

protected $fillable = [
    'lab_id',          // ← tambahkan
    'category',
    'item_code',
    'item_name',
    'unit',
    'quantity',
    'quantity_available',
    'price',
    'gross_weight',
    'net_weight',
    'spesification',
    'description',
    'chemical_formula',
    'storage',
    'condition',
    'expiry_date',
    'cupboard_location',
    'year',
    'image',
    'active',
    'created_by',
    'updated_by',
];

    protected $casts = [
        'expiry_date' => 'date',
        'active'      => 'boolean',
        'price'       => 'decimal:2',
    ];

    public function loanDetails(): HasMany
    {
        return $this->hasMany(LabLoanDetail::class, 'inventory_id');
    }

    public function isAvailable(int $qty): bool
    {
        return $this->quantity_available >= $qty;
    }

    public function decreaseStock(int $qty): void
    {
        $this->decrement('quantity_available', $qty);
    }

    public function increaseStock(int $qty): void
    {
        $this->increment('quantity_available', $qty);
    }

    /**
     * Total stok yang sedang di-reservasi (dipesan tapi belum diambil)
     * Status pending + approved dianggap sudah memesan
     */
    public function getReservedQuantity(): int
    {
        return $this->loanDetails()
            ->whereHas('labLoan', function ($query) {
                $query->whereIn('status', ['pending', 'approved'])
                    ->whereNull('return_date'); // ← tambahkan ini!
            })
            ->sum('quantity');
    }

    /**
     * Stok yang BENAR-BENAR tersisa (stok fisik - reservasi)
     */
    public function getActualAvailable(): int
    {
        return $this->quantity_available - $this->getReservedQuantity();
    }

    public function lab()
    {
        return $this->belongsTo(Lab::class);
    }
}