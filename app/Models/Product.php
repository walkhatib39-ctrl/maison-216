<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'room_id',
        'product_type_id',
        'primary_collection_id',
        'title',
        'slug',
        'price_millimes',
        'compare_at_millimes',
        'stock',
        'sku',
        'brand',
        'sale_mode',
        'quote_only',
        'is_starting_price',
        'is_customizable',
        'showroom_badge',
        'main_image',
        'material_summary',
        'dimension_summary',
        'availability_label',
        'delivery_note',
        'finish_summary',
        'short_description',
        'long_description',
        'attributes',
        'custom_options',
        'is_active',
    ];

    protected $casts = [
        'attributes' => 'array',
        'custom_options' => 'array',
        'quote_only' => 'boolean',
        'is_starting_price' => 'boolean',
        'is_customizable' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (Product $product) {
            if (empty($product->slug) && !empty($product->title)) {
                $base = Str::slug($product->title);
                $slug = $base;
                $i = 2;
                while (static::where('slug', $slug)->whereKeyNot($product->getKey())->exists()) {
                    $slug = $base . '-' . $i++;
                }
                $product->slug = $slug;
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function productType(): BelongsTo
    {
        return $this->belongsTo(ProductType::class);
    }

    public function primaryCollection(): BelongsTo
    {
        return $this->belongsTo(CatalogCollection::class, 'primary_collection_id');
    }

    public function collections(): BelongsToMany
    {
        return $this->belongsToMany(CatalogCollection::class, 'collection_product', 'product_id', 'collection_id')
            ->withPivot(['is_featured', 'position'])
            ->withTimestamps()
            ->orderBy('collection_product.position');
    }

    public function showroomActivities(): BelongsToMany
    {
        return $this->belongsToMany(ShowroomActivity::class, 'product_showroom_activity')
            ->withPivot('sort_order')
            ->withTimestamps()
            ->orderBy('product_showroom_activity.sort_order')
            ->orderBy('showroom_activities.name');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('position');
    }

    // -------- Price helpers (TND formatting without thousand separator, no decimals) --------

    public function getPriceDinarsAttribute(): int
    {
        return (int) floor(($this->price_millimes ?? 0) / 1000);
    }

    public function getCompareAtDinarsAttribute(): ?int
    {
        if ($this->compare_at_millimes === null) {
            return null;
        }
        return (int) floor($this->compare_at_millimes / 1000);
    }

    public function getPriceDisplayAttribute(): string
    {
        // ex: "259 DT" or "3050 DT"
        return $this->getPriceDinarsAttribute() . ' DT';
    }

    public function getCompareAtDisplayAttribute(): ?string
    {
        $din = $this->getCompareAtDinarsAttribute();
        return $din !== null ? ($din . ' DT') : null;
    }

    // Basic stock status helper
    public function inStock(): bool
    {
        return ($this->stock ?? 0) > 0;
    }

    public function isQuoteOnly(): bool
    {
        return (bool) $this->quote_only || $this->sale_mode === 'sur_mesure';
    }

    public function isDirectlyOrderable(): bool
    {
        return !$this->isQuoteOnly();
    }

    public function getShowroomPriceLabelAttribute(): string
    {
        if ($this->price_millimes === null || $this->price_millimes <= 0) {
            return $this->isQuoteOnly() ? 'Sur devis' : 'Prix à confirmer';
        }

        $prefix = $this->is_starting_price || $this->isQuoteOnly() ? 'À partir de ' : '';

        return $prefix . $this->price_display;
    }

    public function getShowroomBadgeLabelAttribute(): string
    {
        if (filled($this->showroom_badge)) {
            return (string) $this->showroom_badge;
        }

        if ($this->isQuoteOnly()) {
            return 'Sur mesure';
        }

        return 'Standard';
    }

    public function getMainImageUrlAttribute(): ?string
    {
        if (blank($this->main_image)) {
            return null;
        }

        if (Str::startsWith($this->main_image, ['http://', 'https://'])) {
            return $this->main_image;
        }

        return asset(ltrim($this->main_image, '/'));
    }
}
