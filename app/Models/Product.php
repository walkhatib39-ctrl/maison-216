<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'price_millimes',
        'compare_at_millimes',
        'stock',
        'sku',
        'brand',
        'main_image',
        'short_description',
        'long_description',
        'attributes',
        'is_active',
    ];

    protected $casts = [
        'attributes' => 'array',
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
}
