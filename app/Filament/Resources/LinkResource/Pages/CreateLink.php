<?php

namespace App\Filament\Resources\LinkResource\Pages;

use App\Filament\Resources\LinkResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Services\LinkeToService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;

class CreateLink extends CreateRecord
{
    protected static string $resource = LinkResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        try {
            // Log de datos iniciales
            Log::info('Datos iniciales:', $data);

            // Si no es admin, asignar el usuario actual
            if (!Auth::user()?->roles()->where('name', 'Admin')->exists()) {
                $data['user_id'] = Auth::id();
            }

            // Crear el shortlink usando LinkeToService
            $linkeToService = app(LinkeToService::class);
            $shortLinkResponse = $linkeToService->createShortLink($data['url'],"Link referente");

            // Log de respuesta del servicio
            Log::info('Respuesta de LinkeToService:', ['response' => $shortLinkResponse]);

            // Verificar y actualizar los datos con la respuesta del servicio
            if ($shortLinkResponse && is_array($shortLinkResponse)) {
                $data['slug'] = $shortLinkResponse['data']["name"] ?? "dddwwww";
                
                // Asegurarse de que todos los campos requeridos estén presentes
                if (!isset($data['user_id'])) {
                    $data['user_id'] = Auth::id();
                }
                
                if (!isset($data['clicks'])) {
                    $data['clicks'] = 0;
                }
                
                if (!isset($data['is_active'])) {
                    $data['is_active'] = true;
                }

                // Log de datos finales
                Log::info('Datos finales a guardar:', $data);
            } else {
                Log::error('Error: La respuesta del servicio no es válida');
                throw new \Exception('Error al crear el shortlink');
            }

            return $data;
        } catch (\Exception $e) {
            Log::error('Error en mutateFormDataBeforeCreate: ' . $e->getMessage());
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

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
