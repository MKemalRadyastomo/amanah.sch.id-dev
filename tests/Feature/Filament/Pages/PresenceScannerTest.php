<?php

use App\Console\Commands\GeneratePresenceTokenCommand;
use App\Filament\Pages\Dashboard;
use App\Filament\Pages\PresenceScanner;
use App\Settings\PresenceSetting;
use App\States\PresenceStatus\Late;
use App\States\PresenceStatus\Presence;

use function Pest\Laravel\artisan;
use function Pest\Livewire\livewire;

it('it can presence', function () {
    artisan(GeneratePresenceTokenCommand::class);

    $token = app(PresenceSetting::class)->token;
    $presence = auth()->user()->currentPresence();

    livewire(PresenceScanner::class)
        ->dispatch('submit', token: $token)
        ->assertNotified('Berhasil scan masuk');

    expect($presence->refresh())
        ->start_token->toBe($token)
        ->end_token->toBeNull();

    livewire(PresenceScanner::class)
        ->dispatch('submit', token: $token)
        ->assertNotified('Berhasil scan pulang');

    expect($presence->refresh())
        ->start_token->toBe($token)
        ->end_token->toBe($token);

    livewire(PresenceScanner::class)
        ->dispatch('submit', token: $token)
        ->assertNotified('Anda sudah scan masuk dan pulang');

    artisan(GeneratePresenceTokenCommand::class);

    livewire(PresenceScanner::class)
        ->dispatch('submit', token: $token)
        ->assertNotified('QR Code tidak valid')
        ->assertRedirect(Dashboard::getUrl());
});

it('can change status to presence', function () {
    artisan(GeneratePresenceTokenCommand::class);

    $token = app(PresenceSetting::class)->token;
    $presence = auth()->user()->currentPresence();

    livewire(PresenceScanner::class)
        ->dispatch('submit', token: $token)
        ->assertNotified('Berhasil scan masuk');

    expect($presence->refresh())
        ->start_token->toBe($token)
        ->end_token->toBeNull()
        ->status->toBeInstanceOf(Presence::class);
});

it('not change status if permit requested', function () {
    artisan(GeneratePresenceTokenCommand::class);

    $token = app(PresenceSetting::class)->token;
    $presence = auth()->user()->currentPresence();

    $presence->update([
        'reason' => 'Terlambat',
        'status' => Late::class,
    ]);

    livewire(PresenceScanner::class)
        ->dispatch('submit', token: $token)
        ->assertNotified('Berhasil scan masuk');

    expect($presence->refresh())
        ->start_token->toBe($token)
        ->end_token->toBeNull()
        ->status->toBeInstanceOf(Late::class);
});
