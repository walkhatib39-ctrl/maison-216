<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    public const TYPE_QUOTE = 'quote';
    public const TYPE_PROFESSIONAL = 'professional';
    public const TYPE_CONTACT = 'contact';

    public const STATUS_NEW = 'new';
    public const STATUS_CONTACTED = 'contacted';
    public const STATUS_QUALIFIED = 'qualified';
    public const STATUS_WON = 'won';
    public const STATUS_LOST = 'lost';
    public const STATUS_ARCHIVED = 'archived';

    public const PRIORITY_LOW = 'low';
    public const PRIORITY_NORMAL = 'normal';
    public const PRIORITY_HIGH = 'high';

    protected $fillable = [
        'type',
        'source_page_path',
        'source_url',
        'name',
        'email',
        'phone',
        'company',
        'profession',
        'subject',
        'message',
        'payload',
        'status',
        'priority',
        'admin_notes',
        'last_contacted_at',
    ];

    protected $casts = [
        'payload' => 'array',
        'last_contacted_at' => 'datetime',
    ];

    public static function types(): array
    {
        return [
            self::TYPE_QUOTE => 'Devis',
            self::TYPE_PROFESSIONAL => 'Professionnel',
            self::TYPE_CONTACT => 'Contact',
        ];
    }

    public static function statuses(): array
    {
        return [
            self::STATUS_NEW => 'Nouveau',
            self::STATUS_CONTACTED => 'Contacte',
            self::STATUS_QUALIFIED => 'Qualifie',
            self::STATUS_WON => 'Gagne',
            self::STATUS_LOST => 'Perdu',
            self::STATUS_ARCHIVED => 'Archive',
        ];
    }

    public static function priorities(): array
    {
        return [
            self::PRIORITY_LOW => 'Basse',
            self::PRIORITY_NORMAL => 'Normale',
            self::PRIORITY_HIGH => 'Haute',
        ];
    }

    public function scopeOpen(Builder $query): Builder
    {
        return $query->whereNotIn('status', [self::STATUS_WON, self::STATUS_LOST, self::STATUS_ARCHIVED]);
    }

    public function typeLabel(): string
    {
        return self::types()[$this->type] ?? $this->type;
    }

    public function statusLabel(): string
    {
        return self::statuses()[$this->status] ?? $this->status;
    }

    public function priorityLabel(): string
    {
        return self::priorities()[$this->priority] ?? $this->priority;
    }

    public function whatsappUrl(): ?string
    {
        $digits = preg_replace('/\D+/', '', (string) $this->phone);

        if (!$digits) {
            return null;
        }

        if (strlen($digits) === 8) {
            $digits = '216' . $digits;
        }

        return 'https://wa.me/' . $digits;
    }
}
