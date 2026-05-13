<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RealizationImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'realization_id',
        'image_path',
        'alt_text',
        'caption',
        'sort_order',
    ];

    public function realization(): BelongsTo
    {
        return $this->belongsTo(Realization::class);
    }

    public function imageUrl(): string
    {
        return Realization::imageUrl($this->image_path);
    }
}
