<?php

namespace App\States\PresenceStatus;

class Sick extends PresenceStatus
{
    public static string $name = 'sick';

    public function color(): string
    {
        return 'warning';
    }

    public function label(): string
    {
        return 'Sakit';
    }
}
