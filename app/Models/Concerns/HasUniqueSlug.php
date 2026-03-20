<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasUniqueSlug
{
    protected static function bootHasUniqueSlug(): void
    {
        static::saving(function (Model $model): void {
            $sourceColumn = method_exists($model, 'slugSourceColumn')
                ? $model->slugSourceColumn()
                : 'name';

            $slugColumn = method_exists($model, 'slugColumn')
                ? $model->slugColumn()
                : 'slug';

            $sourceValue = trim((string) ($model->{$sourceColumn} ?? ''));

            if ($sourceValue === '') {
                return;
            }

            $base = Str::slug((string) ($model->{$slugColumn} ?: $sourceValue));
            if ($base === '') {
                return;
            }

            $slug = $base;
            $i = 2;

            while (
                $model->newQuery()
                    ->where($slugColumn, $slug)
                    ->when($model->getKey(), fn ($query) => $query->whereKeyNot($model->getKey()))
                    ->exists()
            ) {
                $slug = $base . '-' . $i++;
            }

            $model->{$slugColumn} = $slug;
        });
    }
}
