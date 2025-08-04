<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccountPresenceResource\Pages;
use App\Models\Presence;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class AccountPresenceResource extends Resource
{
    protected static ?string $model = Presence::class;

    protected static ?string $slug = 'account-presences';

    protected static ?string $recordTitleAttribute = 'id';

    protected static ?string $label = 'Kehadiran';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Akun Saya';

    protected static bool $shouldSkipAuthorization = true;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereBelongsTo(auth()->user());
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('user.name')
                    ->label('Nama'),
            ]);
    }

    /**
     * @throws \Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d F Y'),
                TextColumn::make('start_at')
                    ->label('Masuk')
                    ->dateTime('H:i')
                    ->color(fn (Presence $presence) => $presence->start_at?->lessThanOrEqualTo(now()->setTime(7, 15)) ? null : 'danger'),
                TextColumn::make('end_at')
                    ->label('Pulang')
                    ->dateTime('H:i')
                    ->color(fn (Presence $presence) => $presence->end_at?->greaterThanOrEqualTo(now()->setTime(15, 00)) ? null : 'danger'),
                TextColumn::make('status')
                    ->spatieBadge(),
                TextColumn::make('reason')
                    ->label('Keterangan'),
            ])
            ->filters([
                DateRangeFilter::make('created_at')
                    ->label('Tanggal')
                    ->defaultThisMonth()
                    ->removableIndicator(false),
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAccountPresences::route('/'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [];
    }
}
