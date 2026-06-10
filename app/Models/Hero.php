<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    use Blameable;

    protected $fillable = [
        'title',
        'subtitle',

        'video_url',
        'poster_image',

        'button_text',
        'button_url',

        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function getVideoIdAttribute(): ?string
    {
        if (!$this->video_url) {
            return null;
        }

        preg_match(
            '/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([^&\n?#]+)/',
            $this->video_url,
            $matches
        );

        return $matches[1] ?? null;
    }
}