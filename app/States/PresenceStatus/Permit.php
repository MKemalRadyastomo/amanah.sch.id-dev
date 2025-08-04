<?php

namespace App\States\PresenceStatus;

class Permit extends PresenceStatus
{
    public static string $name = 'permit';

    public function color(): string
    {
        return 'warning';
    }

    public function label(): string
    {
        return 'Izin';
    }
}
