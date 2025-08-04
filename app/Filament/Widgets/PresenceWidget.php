<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;

class PresenceWidget extends StatsOverviewWidget
{
    protected static bool $isLazy = false;

    protected static ?string $pollingInterval = null;

    protected function getColumns(): int
    {
        return 2;
    }

    protected function getStats(): array
    {
        $presence = auth()->user()->currentPresence();

        return [
            StatsOverviewWidget\Stat::make('Scan Masuk', $presence->start_at?->format('H:i') ?? '-')
                ->description('07:15')
                ->color($presence->start_at?->lessThanOrEqualTo(now()->setTime(7, 15)) ? 'success' : 'danger'),
            StatsOverviewWidget\Stat::make('Scan Pulang', $presence->end_at?->format('H:i') ?? '-')
                ->description('15:00')
                ->color($presence->end_at?->greaterThanOrEqualTo(now()->setTime(15, 00)) ? 'success' : 'danger'),
        ];
    }
}
