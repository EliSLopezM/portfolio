<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;

/**
 * Modelos con columnas `position` y `visible` administrables desde el dashboard.
 */
trait Orderable
{
    public static function bootOrderable(): void
    {
        static::creating(function ($model) {
            if (! $model->position) {
                $model->position = (int) static::query()->max('position') + 1;
            }
        });
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('position')->orderBy('id');
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('visible', true);
    }
}
