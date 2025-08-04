<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Enums\Roles;
use App\Filament\Resources\UserResource;
use App\Models\User;
use DB;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Throwable;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['role'] = Roles::from($this->record->roles->first()?->name)->value;

        return parent::mutateFormDataBeforeFill($data);
    }

    /**
     * @throws Throwable
     */
    protected function handleRecordUpdate(Model|User $record, array $data): Model
    {
        return DB::transaction(function () use ($record, $data) {
            $role = $data['role'];
            unset($data['role']);

            $record->syncRoles($role);
            $record->save();

            return parent::handleRecordUpdate($record, $data);
        });
    }
}
