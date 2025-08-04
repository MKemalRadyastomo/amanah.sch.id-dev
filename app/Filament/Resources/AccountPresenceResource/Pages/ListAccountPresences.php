<?php

namespace App\Filament\Resources\AccountPresenceResource\Pages;

use App\Filament\Resources\AccountPresenceResource;
use Filament\Resources\Pages\ListRecords;

class ListAccountPresences extends ListRecords
{
    protected static string $resource = AccountPresenceResource::class;

    protected function getActions(): array
    {
        return [
        ];
    }
}
