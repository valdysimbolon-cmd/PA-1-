<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LabLoan extends Model
{
    protected $table = 'lab_loan';

    protected $fillable = [
        'nim', 'borrower_name', 'study_program', 'research_title',
        'planned_borrow_date', 'planned_return_date',
        'return_date', 'returned_date',
        'receipt_number', 'status', 'admin_notes', 'lab_id',
    ];

    protected $casts = [
        'planned_borrow_date' => 'date',
        'planned_return_date' => 'date',
        'return_date'         => 'date',
        'returned_date'       => 'date',
    ];

    public function details(): HasMany
    {
        return $this->hasMany(LabLoanDetail::class, 'lab_loan_id');
    }

    public function lab(): BelongsTo
    {
        return $this->belongsTo(Lab::class, 'lab_id');
    }

    public static function generateReceiptNumber(): string
    {
        $year = now()->year;
        $last = self::whereYear('created_at', $year)->lockForUpdate()->count();
        $seq  = str_pad($last + 1, 4, '0', STR_PAD_LEFT);
        return "PJM-{$year}-{$seq}";
    }

    public function statusLabel(): string
    {
        return match($this->status) {
            'pending'  => 'Menunggu Persetujuan',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'returned' => 'Dikembalikan',
            default    => '-',
        };
    }

    public function statusBadge(): string
    {
        return match($this->status) {
            'pending'  => 'warning',
            'approved' => 'success',
            'rejected' => 'danger',
            'returned' => 'secondary',
            default    => 'light',
        };
    }
}