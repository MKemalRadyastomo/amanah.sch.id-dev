<?php

namespace App\States\UserStatus;

use Spatie\ModelStates\Attributes\DefaultState;
use Spatie\ModelStates\State;

#[
    DefaultState(Active::class),
]
abstract class UserStatus extends State
{
    public static string $name;

    abstract public function color(): string;

    abstract public function label(): string;
}
