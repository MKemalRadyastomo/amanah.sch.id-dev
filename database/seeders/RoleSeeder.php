<?php

namespace Database\Seeders;

use App\Enums\Roles;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Roles::cases() as $role) {
            Role::findOrCreate($role->value);
        }
    }
}
