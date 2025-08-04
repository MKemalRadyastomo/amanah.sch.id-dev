<?php

namespace App\States\UserStatus;

class Active extends UserStatus
{
    public static string $name = 'active';

    public function color(): string
    {
        return 'success';
    }

    public function label(): string
    {
        return 'Aktif';
    }
}
