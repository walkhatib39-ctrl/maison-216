<?php

namespace App\Models;

use App\Support\SiteSettings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MediaAsset extends Model
{
    protected $fillable = [
        'path',
        'filename',
        'extension',
        'mime_type',
        'size',
        'width',
        'height',
        'source',
        'alt_text',
        'uploaded_by',
        'last_seen_at',
    ];

    protected $casts = [
        'last_seen_at' => 'datetime',
    ];

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function getPublicUrlAttribute(): string
    {
        return SiteSettings::assetUrl($this->path) ?: asset($this->path);
    }

    public function getHumanSizeAttribute(): string
    {
        $size = (int) ($this->size ?? 0);

        if ($size <= 0) {
            return 'Taille inconnue';
        }

        if ($size < 1024) {
            return $size . ' o';
        }

        if ($size < 1024 * 1024) {
            return round($size / 1024, 1) . ' Ko';
        }

        return round($size / 1024 / 1024, 1) . ' Mo';
    }

    public function getDimensionsLabelAttribute(): string
    {
        if (!$this->width || !$this->height) {
            return '';
        }

        return $this->width . ' x ' . $this->height . ' px';
    }
}
