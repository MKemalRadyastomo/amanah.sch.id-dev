<?php

namespace App\States\UserStatus;

class Inactive extends UserStatus
{
    public static string $name = 'inactive';

    public function color(): string
    {
        return 'danger';
    }

    public function label(): string
    {
        return 'Tidak Aktif';
    }
}
