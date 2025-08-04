<?php

namespace App\States\PresenceStatus;

class Late extends PresenceStatus
{
    public static string $name = 'late';

    public function color(): string
    {
        return 'info';
    }

    public function label(): string
    {
        return 'Terlambat';
    }
}
