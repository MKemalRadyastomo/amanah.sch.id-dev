<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\PresenceWidget;
use App\States\PresenceStatus\Alpha;
use App\States\PresenceStatus\Presence;
use App\States\PresenceStatus\PresenceStatus;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Notifications\Notification;
use Filament\Pages\Dashboard as FilamentDashboard;
use Filament\Widgets\AccountWidget;

class Dashboard extends FilamentDashboard implements HasInfolists
{
    use InteractsWithInfolists;

    public function getWidgets(): array
    {
        return [
            AccountWidget::class,
            PresenceWidget::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('scan')
                ->label('Scan Kehadiran')
                ->icon('heroicon-o-camera')
                ->url(PresenceScanner::getSlug()),
            Action::make('permit_request')
                ->label('Ajukan Izin')
                ->icon('heroicon-o-information-circle')
                ->form([
                    Select::make('status')
                        ->label('Jenis Izin')
                        ->options(PresenceStatus::getOptions()->except([Alpha::$name, Presence::$name])),
                    Textarea::make('reason')
                        ->label('Keterangan')
                        ->required(),
                ])
                ->action(function (array $data) {
                    /** @var \App\Models\User $user */
                    $user = auth()->user();

                    $user->currentPresence()->update($data);

                    Notification::make()
                        ->title('Berhasil mengajukan izin')
                        ->success()
                        ->send();
                }),
        ];
    }
}
