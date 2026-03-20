<?php

namespace App\Models;

use App\Models\Concerns\HasUniqueSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductType extends Model
{
    use HasFactory;
    use HasUniqueSlug;

    protected $fillable = [
        'room_id',
        'name',
        'slug',
        'code',
        'short_label',
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

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class)->orderBy('position')->orderBy('name');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class)->latest();
    }
}
