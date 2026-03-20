<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'room_id',
        'product_type_id',
        'name',
        'slug',
        'icon',
        'featured_image',
        'category_kind',
        'landing_intro',
        'landing_outro',
        'is_indexable',
        'position',
    ];

    protected $casts = [
        'is_indexable' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (Category $category) {
            if (empty($category->slug) && !empty($category->name)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::deleting(function (Category $category) {
            // Delete associated products
            $category->products()->each(function ($product) {
                $product->delete();
            });
            
            // Delete children categories (this will trigger this same event for children)
            $category->children()->each(function ($child) {
                $child->delete();
            });
        });
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('position');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getTotalProductsCountAttribute()
    {
        // Use eager loaded count if available, otherwise count()
        $count = $this->products_count ?? $this->products()->count();

        // Recursively add children's counts
        // Ensure 'children' relation is loaded to avoid N+1 loop if possible, 
        // strictly speaking it will lazy load if not eager loaded, which is fine for individual access but bad for loops.
        // We will optimize controller to eager load children.
        foreach ($this->children as $child) {
            $count += $child->total_products_count;
        }

        return $count;
    }
}
