<?php

use App\Filament\Resources\PresenceResource;
use App\Models\Presence;

use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

dataset('presence', [
    fn () => Presence::factory()->create(),
]);

it('can render index page', function () {
    get(PresenceResource::getUrl())->assertOk();
});

it('can list data', function (Presence $presence) {
    livewire(PresenceResource\Pages\ListPresences::class)
        ->assertCanSeeTableRecords([$presence]);
})->with('presence');
