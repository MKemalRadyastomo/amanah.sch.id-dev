<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class PresenceSetting extends Settings
{
    public string $token;

    public ?string $entry_hour;

    public ?string $exit_hour;

    public static function group(): string
    {
        return 'presence';
    }
}
