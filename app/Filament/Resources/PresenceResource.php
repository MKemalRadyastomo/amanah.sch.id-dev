<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PresenceResource\Pages;
use App\Models\Presence;
use Exception;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class PresenceResource extends Resource
{
    protected static ?string $model = Presence::class;

    protected static ?string $slug = 'presences';

    protected static ?string $recordTitleAttribute = 'id';

    protected static ?string $navigationIcon = 'heroicon-o-check-circle';

    protected static ?string $label = 'Kehadiran';

    protected static ?string $navigationGroup = 'Pegawai';

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Nama'),
                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d F Y'),
                TextColumn::make('start_at')
                    ->label('Masuk')
                    ->dateTime('H:i')
                    ->color(fn (Presence $presence) => $presence->isOverdue() ? null : 'danger'),
                TextColumn::make('end_at')
                    ->label('Pulang')
                    ->dateTime('H:i')
                    ->color(fn (Presence $presence) => $presence->isUntimely() ? null : 'danger'),
                TextColumn::make('status')
                    ->spatieBadge(),
                TextColumn::make('reason')
                    ->label('Keterangan'),
            ])
            ->filters([
                DateRangeFilter::make('created_at')
                    ->label('Tanggal')
                    ->defaultToday()
                    ->removableIndicator(false),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPresences::route('/'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [];
    }
}
