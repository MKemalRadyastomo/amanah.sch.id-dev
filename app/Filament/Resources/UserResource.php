<?php

namespace App\Filament\Resources;

use App\Enums\Roles;
use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Ysfkaya\FilamentPhoneInput\Tables\PhoneColumn;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $slug = 'teachers';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $label = 'Guru';

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $navigationGroup = 'Pegawai';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Biodata')
                    ->columns([
                        'sm' => 2,
                    ])
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->label('Nama Lengkap')
                            ->columnSpanFull(),

                        TextInput::make('personal_number')
                            ->required()
                            ->label('NIY'),

                        PhoneInput::make('phone')
                            ->label('Nomor Telepon (WhatsApp)')
                            ->required(),

                        Textarea::make('address')
                            ->required()
                            ->label('Alamat')
                            ->columnSpanFull(),

                        TextInput::make('place_of_birth')
                            ->required()
                            ->label('Tempat Lahir'),

                        DatePicker::make('date_of_birth')
                            ->required()
                            ->label('Tanggal Lahir')
                            ->native(false),

                        DatePicker::make('registered_at')
                            ->required()
                            ->label('Tanggal Masuk')
                            ->native(false),

                        SpatieMediaLibraryFileUpload::make('photo')
                            ->label('Foto')
                            ->image()
                            ->columnSpanFull(),
                    ]),
                Section::make('Akun')
                    ->schema([
                        TextInput::make('email')
                            ->required(),
                        Select::make('role')
                            ->label('Jabatan')
                            ->required()
                            ->options([
                                Roles::OPERATOR->value => 'Operator',
                                Roles::TEACHER->value => 'Guru',
                                Roles::ADMIN->value => 'Tata Usaha',
                            ])
                            ->native(false),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('photo')
                    ->label('Foto')
                    ->circular(),

                TextColumn::make('personal_number')
                    ->label('NIY')
                    ->searchable(),

                TextColumn::make('name')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable(),

                PhoneColumn::make('phone')
                    ->label('No. Telepon'),

                TextColumn::make('roles.name')
                    ->label('Jabatan')
                    ->formatStateUsing(fn ($state) => Roles::from($state)),

                TextColumn::make('status')
                    ->spatieBadge(),
            ])
            ->actions([
                EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email'];
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->hasAnyRole(Roles::ADMIN->value, Roles::HEADMASTER->value);
    }
}
