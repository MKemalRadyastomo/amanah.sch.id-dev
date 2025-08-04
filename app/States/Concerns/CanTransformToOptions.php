<?php

namespace App\States\Concerns;

use Illuminate\Support\Collection;
use Spatie\LaravelOptions\Options;

trait CanTransformToOptions
{
    public static function getOptions(): Collection
    {
        $data = Options::forStates(static::class);

        return collect($data)->mapWithKeys(function ($item) {
            return [$item['value'] => $item['label']];
        });
    }
}
