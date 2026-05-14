<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Throwable;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'group',
    ];

    protected $casts = [
        'value' => 'array',
    ];

    public static function get(string $key, mixed $default = null): mixed
    {
        try {
            if (!Schema::hasTable((new static())->getTable())) {
                return $default;
            }

            $val = static::query()->where('key', $key)->value('value');

            return $val ?? $default;
        } catch (Throwable) {
            return $default;
        }
    }

    public static function set(string $key, mixed $value, ?string $group = null): Setting
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group]
        );
    }
}
