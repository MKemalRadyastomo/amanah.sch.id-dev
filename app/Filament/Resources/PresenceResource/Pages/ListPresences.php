<?php

namespace App\Filament\Resources\PresenceResource\Pages;

use App\Filament\Exports\PresenceExporter;
use App\Filament\Resources\PresenceResource;
use Carbon\Carbon;
use Filament\Actions\ExportAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListPresences extends ListRecords
{
    protected static string $resource = PresenceResource::class;

    protected function getActions(): array
    {
        return [
            ExportAction::make()
                ->exporter(PresenceExporter::class)
                ->label('Rekap Kehadiran')
                ->columnMapping(false)
                ->modalHeading('Rekap Kehadiran')
                ->modalSubmitActionLabel('Rekap')
                ->modifyQueryUsing(function (Builder $query, array $data) {
                    $date = explode('-', $data['created_at']);

                    return $this->getModel()::query()
                        ->whereBetween('created_at', [
                            Carbon::make($date[0])->startOfDay(),
                            Carbon::make($date[1])->endOfDay(),
                        ]);
                })
                ->successNotificationTitle('Sedang Merekap'),
        ];
    }
}
