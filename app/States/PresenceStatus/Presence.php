<?php

namespace App\States\PresenceStatus;

class Presence extends PresenceStatus
{
    public static string $name = 'presence';

    public function color(): string
    {
        return 'success';
    }

    public function label(): string
    {
        return 'Masuk';
    }
}
