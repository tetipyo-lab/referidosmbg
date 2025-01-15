<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;


class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;
    
    protected function mutateFormDataBeforeSave(array $data): array
    {
        try {
            $data['phone'] = preg_replace('/^1?(\d{10})$/', '+1$1', $data['phone']);
            Log::info('Registro actualizado exitosamente');
            return $data;
        } catch (\Exception $e) {
            Log::error('Error al actualizar el registro: ' . $e->getMessage());
            throw $e;
        }
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        try {
            $record = $this->getRecord();
            $record->update($data);
            Log::info('Registro actualizado exitosamente:', ['id' => $record->id]);
            return $record;
        } catch (\Exception $e) {
            Log::error('Error al actualizar el registro: ' . $e->getMessage());
            throw $e;
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
