<?php

namespace Database\Factories;

use App\Models\Presence;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Str;

class PresenceFactory extends Factory
{
    protected $model = Presence::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'start_at' => now()->setTime(7, 0),
            'start_token' => Str::random(),
            'end_at' => now()->setTime(7, 0)->addHours(8),
            'end_token' => Str::random(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
