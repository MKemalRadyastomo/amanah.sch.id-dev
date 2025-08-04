<?php

namespace Database\Seeders;

use App\Enums\Roles;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call(RoleSeeder::class);

        /** @var User $user */
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@aaiischool.id',
        ]);

        $user->assignRole(Roles::SUPER_ADMIN);
    }
}
