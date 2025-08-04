<?php

namespace App\States\PresenceStatus;

class Alpha extends PresenceStatus
{
    public static string $name = 'alpha';

    public function color(): string
    {
        return 'danger';
    }

    public function label(): string
    {
        return 'Alpha';
    }
}
