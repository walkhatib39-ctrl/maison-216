<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkshopOrderFile extends Model
{
    use HasFactory;

    public const TYPE_CLIENT_PHOTO = 'photo_client';
    public const TYPE_MEASURE_PHOTO = 'photo_mesure';
    public const TYPE_SKETCH = 'croquis';
    public const TYPE_PLAN = 'plan';
    public const TYPE_INSPIRATION = 'inspiration';
    public const TYPE_PRODUCTION_PHOTO = 'photo_production';
    public const TYPE_FINAL_PHOTO = 'photo_finale';
    public const TYPE_OTHER = 'autre';

    protected $fillable = [
        'workshop_order_id',
        'file_type',
        'file_path',
        'original_name',
        'mime_type',
        'size',
        'notes',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(WorkshopOrder::class, 'workshop_order_id');
    }

    public function fileUrl(): string
    {
        return asset(ltrim($this->file_path, '/'));
    }

    public function isImage(): bool
    {
        return str_starts_with((string) $this->mime_type, 'image/');
    }

    public function fileTypeLabel(): string
    {
        return self::fileTypes()[$this->file_type] ?? $this->file_type;
    }

    public static function fileTypes(): array
    {
        return [
            self::TYPE_CLIENT_PHOTO => 'Photos client',
            self::TYPE_MEASURE_PHOTO => 'Photos de mesure',
            self::TYPE_SKETCH => 'Croquis',
            self::TYPE_PLAN => 'Plans',
            self::TYPE_INSPIRATION => 'Inspirations',
            self::TYPE_PRODUCTION_PHOTO => 'Photos de production',
            self::TYPE_FINAL_PHOTO => 'Photos finales',
            self::TYPE_OTHER => 'Autres fichiers',
        ];
    }
}
