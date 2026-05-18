<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkshopClient extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const TYPE_INDIVIDUAL = 'particulier';
    public const TYPE_PROFESSIONAL = 'professionnel';

    protected $fillable = [
        'name',
        'phone',
        'whatsapp',
        'city',
        'address',
        'client_type',
        'internal_notes',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(WorkshopOrder::class);
    }

    public function clientTypeLabel(): string
    {
        return self::clientTypes()[$this->client_type] ?? $this->client_type;
    }

    public static function clientTypes(): array
    {
        return [
            self::TYPE_INDIVIDUAL => 'Particulier',
            self::TYPE_PROFESSIONAL => 'Professionnel',
        ];
    }
}
