<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class ShowroomActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'headline',
        'description',
        'meta_title',
        'meta_description',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (ShowroomActivity $activity) {
            if (empty($activity->slug) && filled($activity->name)) {
                $activity->slug = Str::slug($activity->name);
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_showroom_activity')
            ->withPivot('sort_order')
            ->withTimestamps()
            ->orderBy('product_showroom_activity.sort_order')
            ->orderBy('products.title');
    }
}
