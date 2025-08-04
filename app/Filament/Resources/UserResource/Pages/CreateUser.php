<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use DB;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function getActions(): array
    {
        return [

        ];
    }

    protected function handleRecordCreation(array $data): Model
    {
        return DB::transaction(function () use ($data) {
            $role = $data['role'];
            unset($data['role']);

            /** @var \App\Models\User $user */
            $user = parent::handleRecordCreation($data);
            $user->assignRole($role);
            $user->save();

            return $user;
        });
    }
}
