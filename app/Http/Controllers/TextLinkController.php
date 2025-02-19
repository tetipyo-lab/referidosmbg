<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\SmsInbox;
use Illuminate\Validation\ValidationException;

class TextLinkController extends Controller
{
    /**
     * Manejar los webhooks de mensajes entrantes de TextLink SMS.
     */
    public function receive(Request $request)
    {
        try {
            Log::info('Webhook recibido de TextLink SMS:', ['request' => $request->all()]);

            // Validar los datos del webhook
            $data = $request->validate([
                'secret' => 'required|string',
                'phone_number' => 'required|string',  // Número del remitente
                'received' => 'required|string', // Número receptor (tu línea)
                'text' => 'required|string', // Contenido del mensaje
                'timestamp' => 'nullable|date', // Fecha opcional
            ]);

            // Guardar el mensaje en la base de datos
            SmsInbox::create([
                'provider_id' => 2,
                'sender' => $data['phone_number'],
                'recipient' => $data['received'],
                'message' => $data['text'],
                'received_at' => $data['timestamp'] ?? now(),
            ]);

            // Registrar en logs
            Log::info('SMS entrante guardado correctamente:', $data);

            return response()->json(['status' => 'success', 'message' => 'SMS recibido'], 200);
        } catch (ValidationException $e) {
            Log::error('Error de validación en el webhook de TextLink SMS:', $e->errors());
            return response()->json(['status' => 'error', 'message' => 'Datos inválidos'], 422);
        } catch (\Exception $e) {
            Log::error('Error procesando el webhook de TextLink SMS:', ['error' => $e->getMessage()]);
            return response()->json(['status' => 'error', 'message' => 'Error interno'], 500);
        }
    }
}
