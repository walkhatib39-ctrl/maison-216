<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkshopOrder extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const STATUS_NEW = 'Nouvelle commande';
    public const STATUS_MEASURE = 'Mesure à faire';
    public const STATUS_PRICE = 'Prix à valider';
    public const STATUS_DEPOSIT = 'Acompte reçu';
    public const STATUS_PRODUCTION = 'En production';
    public const STATUS_READY = 'Prêt à livrer';
    public const STATUS_DELIVERED = 'Livré';
    public const STATUS_INSTALLED = 'Installé';
    public const STATUS_CLOSED = 'Clôturé';
    public const STATUS_CANCELED = 'Annulé';

    public const CATEGORY_WOOD = 'bois';
    public const CATEGORY_ALUMINIUM = 'aluminium';
    public const CATEGORY_METAL = 'metal';
    public const CATEGORY_MIXED = 'mixte';

    protected $fillable = [
        'workshop_client_id',
        'title',
        'category',
        'description',
        'dimensions',
        'finish',
        'total_amount',
        'deposit_amount',
        'ordered_at',
        'delivery_due_at',
        'status',
        'internal_notes',
    ];

    protected $casts = [
        'total_amount' => 'decimal:3',
        'deposit_amount' => 'decimal:3',
        'ordered_at' => 'date',
        'delivery_due_at' => 'date',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(WorkshopClient::class, 'workshop_client_id');
    }

    public function files(): HasMany
    {
        return $this->hasMany(WorkshopOrderFile::class);
    }

    public function getRemainingAmountAttribute(): float
    {
        return max(0, (float) $this->total_amount - (float) $this->deposit_amount);
    }

    public function remainingAmountDisplay(): string
    {
        return number_format($this->remaining_amount, 0, ',', ' ') . ' DT';
    }

    public function totalAmountDisplay(): string
    {
        return number_format((float) $this->total_amount, 0, ',', ' ') . ' DT';
    }

    public function depositAmountDisplay(): string
    {
        return number_format((float) $this->deposit_amount, 0, ',', ' ') . ' DT';
    }

    public function categoryLabel(): string
    {
        return self::categories()[$this->category] ?? $this->category;
    }

    public function isLate(): bool
    {
        return $this->delivery_due_at
            && $this->delivery_due_at->isPast()
            && ! in_array($this->status, [self::STATUS_CLOSED, self::STATUS_CANCELED], true);
    }

    public function scopeOpen(Builder $query): Builder
    {
        return $query->whereNotIn('status', [self::STATUS_CLOSED, self::STATUS_CANCELED]);
    }

    public static function statuses(): array
    {
        return [
            self::STATUS_NEW,
            self::STATUS_MEASURE,
            self::STATUS_PRICE,
            self::STATUS_DEPOSIT,
            self::STATUS_PRODUCTION,
            self::STATUS_READY,
            self::STATUS_DELIVERED,
            self::STATUS_INSTALLED,
            self::STATUS_CLOSED,
            self::STATUS_CANCELED,
        ];
    }

    public static function categories(): array
    {
        return [
            self::CATEGORY_WOOD => 'Bois',
            self::CATEGORY_ALUMINIUM => 'Aluminium',
            self::CATEGORY_METAL => 'Métal',
            self::CATEGORY_MIXED => 'Mixte',
        ];
    }
}
