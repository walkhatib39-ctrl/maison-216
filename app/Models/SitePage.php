<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SitePage extends Model
{
    protected $fillable = [
        'path',
        'silo',
        'parent_path',
        'page_type',
        'admin_title',
        'public_title',
        'description_snapshot',
        'meta_title',
        'meta_description',
        'og_image',
        'is_indexable',
        'is_obsolete',
        'priority',
        'sort_order',
        'last_seo_reviewed_at',
    ];

    protected $casts = [
        'is_indexable' => 'boolean',
        'is_obsolete' => 'boolean',
        'priority' => 'decimal:1',
        'last_seo_reviewed_at' => 'datetime',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_obsolete', false);
    }

    public function scopeForSilo(Builder $query, ?string $silo): Builder
    {
        return $silo ? $query->where('silo', $silo) : $query;
    }

    public function realizations(): BelongsToMany
    {
        return $this->belongsToMany(Realization::class, 'realization_site_page')
            ->withPivot(['sort_order', 'is_featured_on_page'])
            ->withTimestamps()
            ->orderByPivot('sort_order');
    }

    public function publicUrl(): string
    {
        return url('/' . ltrim($this->path, '/'));
    }

    public function canonicalUrl(): string
    {
        return $this->publicUrl();
    }

    public function hasCompleteMeta(): bool
    {
        return filled($this->meta_title) && filled($this->meta_description);
    }
}
