<?php

namespace App\Enums\Concerns;

/** @mixin \UnitEnum */
trait CanGetValues
{
    public static function values(): array
    {
        return collect(static::cases())->map(fn ($item) => $item->value)->toArray();
    }
}
