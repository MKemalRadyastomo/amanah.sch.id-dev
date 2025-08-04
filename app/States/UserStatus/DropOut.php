<?php

namespace App\States\UserStatus;

class DropOut extends UserStatus
{
    public static string $name = 'drop_out';

    public function color(): string
    {
        return 'danger';
    }

    public function label(): string
    {
        return 'Keluar';
    }
}
