<?php

namespace App\Models;

use App\Models\Concerns\HasUniqueSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CatalogCollection extends Model
{
    use HasFactory;
    use HasUniqueSlug;

    protected $table = 'collections';

    protected $fillable = [
        'room_id',
        'name',
        'slug',
        'code',
        'aesthetic_family',
        'badge_label',
        'description',
        'position',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function primaryProducts(): HasMany
    {
        return $this->hasMany(Product::class, 'primary_collection_id')->latest();
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'collection_product', 'collection_id', 'product_id')
            ->withPivot(['is_featured', 'position'])
            ->withTimestamps()
            ->orderBy('collection_product.position');
    }
}
