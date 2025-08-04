<?php

namespace App\States\PresenceStatus;

use App\States\Concerns\CanTransformToOptions;
use Spatie\ModelStates\Attributes\DefaultState;
use Spatie\ModelStates\State;

#[
    DefaultState(Alpha::class),
]
abstract class PresenceStatus extends State
{
    use CanTransformToOptions;

    public static string $name;

    abstract public function color(): string;

    abstract public function label(): string;
}
