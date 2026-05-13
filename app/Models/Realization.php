<?php

namespace App\Models;

use App\Models\Concerns\HasUniqueSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Realization extends Model
{
    use HasFactory;
    use HasUniqueSlug;

    public const STATUS_DRAFT = 'draft';
    public const STATUS_PUBLISHED = 'published';

    protected $fillable = [
        'title',
        'slug',
        'project_type',
        'silo',
        'location',
        'short_description',
        'description',
        'cover_image',
        'cover_alt',
        'status',
        'is_featured',
        'completed_at',
        'sort_order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'completed_at' => 'date',
    ];

    public static function statuses(): array
    {
        return [
            self::STATUS_DRAFT => 'Brouillon',
            self::STATUS_PUBLISHED => 'Publie',
        ];
    }

    public static function siloLabels(): array
    {
        return [
            'menuiserie-bois' => 'Menuiserie bois',
            'aluminium' => 'Menuiserie aluminium',
            'fer-metal' => 'Fabrication metallique',
            'sur-mesure' => 'Sur mesure',
            'projets' => 'Projets',
            'global' => 'Global',
        ];
    }

    public function images(): HasMany
    {
        return $this->hasMany(RealizationImage::class)->orderBy('sort_order');
    }

    public function pages(): BelongsToMany
    {
        return $this->belongsToMany(SitePage::class, 'realization_site_page')
            ->withPivot(['sort_order', 'is_featured_on_page'])
            ->withTimestamps()
            ->orderByPivot('sort_order');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_PUBLISHED);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query
            ->orderBy('sort_order')
            ->latest('completed_at')
            ->latest();
    }

    public function statusLabel(): string
    {
        return self::statuses()[$this->status] ?? $this->status;
    }

    public function siloLabel(): string
    {
        return self::siloLabels()[$this->silo] ?? $this->silo;
    }

    public function coverImageUrl(): string
    {
        return self::imageUrl($this->cover_image);
    }

    public static function imageUrl(?string $path): string
    {
        $path = trim((string) $path);

        if ($path === '') {
            return asset('assets/home/amenagement-sur-mesure.jpg');
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        if (Str::startsWith($path, '/')) {
            return url($path);
        }

        if (Str::startsWith($path, 'assets/')) {
            return asset($path);
        }

        return Storage::disk('public')->url($path);
    }

    public function toCardArray(): array
    {
        $image = $this->coverImageUrl();
        $place = $this->location ?: $this->siloLabel();
        $type = $this->project_type ?: $this->title;
        $copy = $this->short_description ?: $this->description ?: $this->title;

        return [
            'title' => $this->title,
            'type' => $type,
            'place' => $place,
            'location' => $this->location,
            'note' => $copy,
            'copy' => $copy,
            'image' => $image,
            'image_url' => $image,
            'alt' => $this->cover_alt ?: $this->title,
            'silo' => $this->silo,
            'silo_label' => $this->siloLabel(),
        ];
    }

    protected function slugSourceColumn(): string
    {
        return 'title';
    }
}
