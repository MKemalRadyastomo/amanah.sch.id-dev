<?php

use App\Enums\Roles;
use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions\DeleteAction;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertModelMissing;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

dataset('user', [
    fn () => User::factory()->create(),
]);

it('can render index page', function () {
    get(UserResource::getUrl())->assertOk();
});

it('can list', function (User $user) {
    livewire(UserResource\Pages\ListUsers::class)
        ->assertCanSeeTableRecords([$user]);
})->with('user');

it('can render create page', function () {
    get(UserResource::getUrl('create'))->assertOk();
});

it('can create', function () {
    $user = User::factory()->make();
    $data['role'] = Roles::ADMIN->value;

    livewire(UserResource\Pages\CreateUser::class)
        ->fillForm([
            'name' => $user->name,
            'email' => $user->email,
            'role' => $data['role'],
            'personal_number' => $user->personal_number,
            'phone' => $user->phone,
            'address' => $user->address,
            'place_of_birth' => $user->place_of_birth,
            'date_of_birth' => $user->date_of_birth,
            'registered_at' => $user->registered_at,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    assertDatabaseHas(User::class, Arr::except($data, ['role', 'phone']));
});

it('can render edit page', function (User $user) {
    $user->assignRole(Roles::ADMIN->value);

    get(UserResource::getUrl('edit', ['record' => $user]))->assertOk();
})->with('user');

it('can update', function (User $user) {
    $user->assignRole(Roles::ADMIN->value);
    $data = Arr::except($user->toArray(), ['status', 'email_verified_at', 'date_of_birth', 'phone', 'registered_at']);
    $newData = User::factory()->make();

    livewire(UserResource\Pages\EditUser::class, ['record' => $user->getRouteKey()])
        ->assertFormSet([
            ...$data,
            'role' => Roles::ADMIN->value,
        ])
        ->fillForm([
            'name' => $newData->name,
            'email' => $newData->email,
            'role' => Roles::OPERATOR->value,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($user->refresh())
        ->name->toBe($newData->name)
        ->email->toBe($newData->email)
        ->roles->first()->name->toBe(Roles::OPERATOR->value);
})->with('user');

it('can delete', function (User $user) {
    $user->assignRole(Roles::ADMIN->value);

    livewire(UserResource\Pages\EditUser::class, ['record' => $user->getRouteKey()])
        ->callAction(DeleteAction::class)
        ->assertHasNoActionErrors();

    assertModelMissing($user);
})->with('user');
