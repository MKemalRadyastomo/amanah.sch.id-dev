<?php

namespace App\Filament\Pages;

use App\Settings\PresenceSetting;
use App\States\PresenceStatus\Alpha;
use App\States\PresenceStatus\Presence;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Livewire\Attributes\On;

class PresenceScanner extends Page
{
    protected static ?string $slug = 'scan-presence';

    protected static string $view = 'filament.pages.presence-scanner';

    protected static ?string $title = 'Scan Kehadiran';

    protected static bool $shouldRegisterNavigation = false;

    #[On('submit')]
    public function submit(string $token): void
    {
        $presence = auth()->user()->currentPresence();
        $currenToken = app(PresenceSetting::class)->token;

        if ($currenToken != $token) {
            Notification::make()
                ->title('QR Code tidak valid')
                ->actions([
                    Action::make('refresh')
                        ->label('Scan ulang')
                        ->url(static::getSlug()),
                ])
                ->danger()
                ->send();

            $this->redirect(Dashboard::getUrl());

            return;
        }

        if (
            filled($presence->start_token)
            && $presence->start_token == $token
            && is_null($presence->end_token)
        ) {
            $presence->update([
                'end_at' => now(),
                'end_token' => $token,
            ]);

            Notification::make()
                ->title('Berhasil scan pulang')
                ->success()
                ->send();

            $this->redirect(Dashboard::getUrl());

            return;
        }

        if (is_null($presence->start_token)) {
            $presence->update([
                'start_at' => now(),
                'start_token' => $token,
            ]);

            if ($presence->status->equals(Alpha::class)) {
                $presence->update([
                    'status' => Presence::class,
                ]);
            }

            Notification::make()
                ->title('Berhasil scan masuk')
                ->success()
                ->send();

            $this->redirect(Dashboard::getUrl());

            return;
        }

        if (filled($presence->start_token) && filled($presence->end_token)) {
            Notification::make()
                ->title('Anda sudah scan masuk dan pulang')
                ->danger()
                ->send();

            $this->redirect(Dashboard::getUrl());

            return;
        }

        Notification::make()
            ->title('Terjadi kesalahan. Silakan klik scan ulang')
            ->actions([
                Action::make('refresh')
                    ->label('Scan ulang')
                    ->url(static::getSlug()),
            ])
            ->danger()
            ->send();

        $this->redirect(Dashboard::getUrl());
    }
}
