<?php

namespace App\Enums;

use App\Enums\Concerns\CanGetValues;
use Filament\Support\Contracts\HasLabel;

enum Roles: string implements HasLabel
{
    use CanGetValues;

    case ADMIN = 'admin';
    case HEADMASTER = 'headmaster';
    case TEACHER = 'teacher';

    case OPERATOR = 'operator';

    case SUPER_ADMIN = 'super_admin';

    public function getLabel(): string
    {
        return match ($this) {
            self::TEACHER => 'Guru',
            self::ADMIN => 'Tata Usaha',
            self::OPERATOR => 'Operator',
            self::HEADMASTER => 'Kepala Sekolah',
            default => '-',
        };
    }
}
