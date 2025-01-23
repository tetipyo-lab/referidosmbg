<?php
namespace App\Filament\Resources\ReferredLinkResource\Pages;

use App\Filament\Resources\ReferredLinkResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Services\LinkeToService;
use App\Services\TextLinkSmsService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use App\Models\User;
use App\Models\Link;

class CreateReferredLink extends CreateRecord
{
    protected static string $resource = ReferredLinkResource::class;

    protected function getTextLinkSmsService(): TextLinkSmsService
    {
        return app(TextLinkSmsService::class);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        try {
            // Log de datos iniciales
            Log::info('Datos iniciales:', $data);
            $userName = Auth::user()->name;
            // Obtener el referral_code a partir del user_id
            if (isset($data['user_id'])) {
                $user = User::find($data['user_id']);
                if (!$user || !$user->referral_code) {
                    Log::error('Error: Referral code no encontrado para el usuario.', ['user_id' => $data['user_id']]);
                    throw new \Exception('El usuario no tiene un código de referido válido.');
                }
                $data['referral_code'] = $user->referral_code;
                $referrer_phone = $user->phone;
            } else {
                Log::error('Error: user_id no proporcionado en los datos.');
                throw new \Exception('El campo user_id es obligatorio.');
            }

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

                // Enviar SMS con el nuevo enlace
                try {
                    $referrerName = explode(" ",$user->name);
                    $smsText = $referrerName. ",\n Soy $userName. Comparte este enlace con tus contactos: " . $data['short_links'].
                    "\n y ayudalos a acceder a beneficios exclusivos. Si tienes dudas, responde 1\n Envía STOP para no recibir más mensajes.";
                    
                    $this->sendToReferrer($referrer_phone, $smsText);
                    Log::info('Mensaje de creacion:', [$smsText]);
                } catch (\Exception $e) {
                    // Log error but don't stop the process
                    Log::error('Error al enviar SMS: ' . $e->getMessage(), [
                        'phone' => $referrer_phone,
                        'message' => $smsText
                    ]);
                }

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
                ->body("El mensaje de texto ha sido enviado correctamente al numero $to") // Usar los datos del modelo
                ->persistent()
                ->send();
        } catch (\Exception $e) {
            Log::error('Error en el envío de SMS', [
                'phone' => $to,
                'error' => $e->getMessage()
            ]);
            Notification::make()
                ->title('Error al enviar SMS!')
                ->danger()
                ->body("El mensaje de texto NO ha sido enviado a $to") // Usar los datos del modelo
                ->persistent()
                ->send();
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