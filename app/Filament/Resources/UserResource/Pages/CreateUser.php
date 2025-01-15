<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;


class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        try {
            $data['phone'] = preg_replace('/^1?(\d{10})$/', '+1$1', $data['phone']);
            Log::info('Registro creado exitosamente:', ['id' => $record->id]);
            return $data;
        } catch (\Exception $e) {
            Log::error('Error al crear el registro: ' . $e->getMessage());
            throw $e;
        }
    }

    protected function handleRecordCreation(array $data): Model
    {
        try {
            $record = static::getModel()::create($data);
            Log::info('Registro creado exitosamente:', ['id' => $record->id]);
            return $record;
        } catch (\Exception $e) {
            Log::error('Error al crear el registro: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
