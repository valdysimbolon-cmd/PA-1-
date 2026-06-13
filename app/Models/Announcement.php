<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Announcement extends Model
{
    use Blameable;

    protected $fillable = [
        'title',
        'content',
        'attachment_file',
        'is_important',
        'expired_at',
        'active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_important' => 'boolean',
        'active'       => 'boolean',
        'expired_at'   => 'date',
    ];

    /**
     * Pengumuman aktif
     */
    public function scopeActive(Builder $query)
    {
        return $query->where('active', true);
    }

    /**
     * Pengumuman yang masih berlaku
     */
    public function scopeValid(Builder $query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expired_at')
              ->orWhere(
                  'expired_at',
                  '>=',
                  Carbon::today()
              );
        });
    }

    /**
     * Pengumuman penting
     */
    public function scopeImportant(Builder $query)
    {
        return $query->where(
            'is_important',
            true
        );
    }

    /**
     * Cek apakah ada lampiran
     */
    public function hasAttachment(): bool
    {
        return !empty(
            $this->attachment_file
        );
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}