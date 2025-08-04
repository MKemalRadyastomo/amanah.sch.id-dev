<?php

namespace Tests;

use App\Enums\Roles;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\seed;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        seed(RoleSeeder::class);

        $user = User::factory()->create();

        actingAs($user);

        $this->actingAsAdmin();
    }

    private function actingAsAdmin(): void
    {
        $user = auth()->user();
        $user->assignRole(Roles::ADMIN->value);
    }
}
