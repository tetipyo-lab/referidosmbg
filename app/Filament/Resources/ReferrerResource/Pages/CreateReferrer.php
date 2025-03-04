<?php

namespace App\Filament\Resources\ReferrerResource\Pages;

use App\Filament\Resources\ReferrerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Link;
use App\Services\LinkeToService;
use App\Services\TextLinkSmsService;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class CreateReferrer extends CreateRecord
{
    protected static string $resource = ReferrerResource::class;
    protected static ?string $title = 'Create Referrer'; // Modifica aquí el título
    protected function getTextLinkSmsService(): TextLinkSmsService
    {
        return app(TextLinkSmsService::class);
    }
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        try {
            $data['phone'] = preg_replace('/^1?(\d{10})$/', '+1$1', $data['phone']);
            // Crear el usuario en la tabla `users`
            $user = User::create([
                'name' => $data['name'], // Asegúrate de capturar estos campos del formulario
                'email' => $data['email'],
                'referral_code' => $data['referral_code'],
                'phone' => $data['phone'],
                'password' => bcrypt("password1310"), // O cualquier lógica de generación de contraseña
                'referred_by' => Auth::id(), // ID del usuario autenticado
            ]);

            // Insertar un rol relacionado con el usuario en la tabla role_user
            $user->roles()->attach(3);
                        
            // Agregar el user_id al registro de `referred_links`
            $data['user_id'] = $user->id;

            // Buscar la URL asociada al link_id
            if (isset($data['link_id'])) {
                $link = Link::find($data['link_id']);
                if (!$link || !$link->is_active) {
                    Log::error('Error: Link no encontrado o inactivo', ['link_id' => $data['link_id']]);
                    throw new \Exception('El link asociado no es válido.');
                }
                $data['url'] = $link->url;
                $linkDescription = $link->description;
                // Agregar el referral_code a la URL
                $parsedUrl = parse_url($data['url']);
                if (isset($parsedUrl['query'])) {
                    $data['url'] .= "&referred={$data['referral_code']}";
                } else {
                    $data['url'] .= "?referred={$data['referral_code']}";
                }
            } else {
                Log::error('Error: link_id no proporcionado en los datos.');
                throw new \Exception('El campo link_id es obligatorio.');
            }

            // Crear el shortlink usando LinkeToService
            $linkeToService = app(LinkeToService::class);
            $shortLinkResponse = $linkeToService->createShortLink($data['url']," ".$data["link_id"],$linkDescription." ID: ".$data['user_id']);
            Log::info('Respuesta de LinkeToService:', ['response' => $shortLinkResponse]);

            if ($shortLinkResponse && is_array($shortLinkResponse)) {
                $data['short_links'] = $shortLinkResponse['data']["short_link"] ?? "https://error.linke.to";
                $data['slug'] = $shortLinkResponse['data']["name"] ?? "error";
                $data['clicks'] = $data['clicks'] ?? 0;
                $userName = Auth::user()->name;
                $referrerName = explode(" ",$data['name']);
                $smsText = $referrerName[0]. ",\n Soy $userName. Comparte este enlace con tus contactos: " . $data['short_links'].
                "\n y ayudalos a acceder a beneficios exclusivos. Si tienes dudas, responde 1\n Envía STOP para no recibir más mensajes.";
                    
                // Enviar SMS con el nuevo enlace
                try {
                    $this->sendToReferrer($data["phone"], $smsText);
                } catch (\Exception $e) {
                    // Log error but don't stop the process
                    Log::error('Error al enviar SMS: ' . $e->getMessage(), [
                        'phone' => $data["phone"],
                        'message' => $smsText
                    ]);
                }

                Log::info('Datos finales a guardar:', $data);
            } else {
                Log::error('Error: La respuesta del servicio no es válida');
                throw new \Exception('Error al crear el shortlink');
            }

            // Retornar los datos modificados
            return $data;
        } catch (\Exception $e) {
            \Log::error('Error creating user: ' . $e->getMessage());
            throw $e; // Re-throw the exception to handle it further up the stack if necessary
        }
    }
    protected function sendToReferrer(string $to, string $message): void
    {
        try {
            $response = $this->getTextLinkSmsService()->sendSms($to, $message);
            
            if (!isset($response['ok']) || !$response['ok']) {
                throw new \Exception($response['error'] ?? 'Error desconocido al enviar SMS');
            }
            
            Log::info('SMS enviado correctamente', [
                'phone' => $to,
                'response' => $response
            ]);
            Notification::make()
                ->title('SMS enviado!')
                ->success()
                ->body("El mensaje de texto ha sido enviado correctamente al numero $to")
                ->persistent()
                ->send();
        } catch (\Exception $e) {
            Log::error('Error en el envío de SMS', [
                'phone' => $to,
                'error' => $e->getMessage()
            ]);
            Notification::make()
                ->title('Error al enviar SMS')
                ->danger()
                ->body("El mensaje de texto NO ha sido enviado a $to") // Usar los datos del modelo
                ->persistent()
                ->send();  // Usando send() en lugar de notify()
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

    protected function afterCreate(): void
    {
        $record = $this->record; // El modelo creado está disponible como `$this->record`

        if ($record) {
            Notification::make()
                ->title('¡Referrer creado!')
                ->success()
                ->body("El referente {$record->name} fue creado correctamente.") // Usar los datos del modelo
                ->send();
        }
    }
    protected function getRedirectUrl(): string
    {
        // Devuelve la URL personalizada a la que deseas redirigir
        return url('admin/referred-links/');
    }
}
