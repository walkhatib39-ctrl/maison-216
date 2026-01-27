<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'phone',
        'phone_alt',
        'email',
        'city',
        'governorate',
        'address',
        'postal_code',
        'payment_method',
        'status',
        'shipping_fee_millimes',
        'subtotal_millimes',
        'total_millimes',
        'customer_note',
        'admin_note',
        'placed_at',
    ];

    protected $casts = [
        'placed_at' => 'datetime',
    ];

    public const STATUS_NEW          = 'Nouveau';
    public const STATUS_CONFIRMED    = 'Confirmé';
    public const STATUS_PREPARING    = 'En préparation';
    public const STATUS_DELIVERING   = 'En livraison';
    public const STATUS_DELIVERED    = 'Livré';
    public const STATUS_CANCELED     = 'Annulé';

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function statusHistory(): HasMany
    {
        return $this->hasMany(OrderStatusHistory::class, 'order_id')->orderBy('created_at', 'desc');
    }

    // Helpers d'affichage en DT (sans séparateur, pas de décimales)
    public function getShippingFeeDinarsAttribute(): int
    {
        return (int) floor(($this->shipping_fee_millimes ?? 0) / 1000);
    }

    public function getSubtotalDinarsAttribute(): int
    {
        return (int) floor(($this->subtotal_millimes ?? 0) / 1000);
    }

    public function getTotalDinarsAttribute(): int
    {
        return (int) floor(($this->total_millimes ?? 0) / 1000);
    }

    public function getTotalDisplayAttribute(): string
    {
        return $this->getTotalDinarsAttribute() . ' DT';
    }
}
