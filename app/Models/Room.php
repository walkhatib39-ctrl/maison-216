<?php

namespace App\Models;

use App\Models\Concerns\HasUniqueSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;
    use HasUniqueSlug;

    protected $fillable = [
        'name',
        'slug',
        'code',
        'tagline',
        'description',
        'position',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function productTypes(): HasMany
    {
        return $this->hasMany(ProductType::class)->orderBy('position')->orderBy('name');
    }

    public function collections(): HasMany
    {
        return $this->hasMany(CatalogCollection::class)->orderBy('position')->orderBy('name');
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class)->orderBy('position')->orderBy('name');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class)->latest();
    }
}
