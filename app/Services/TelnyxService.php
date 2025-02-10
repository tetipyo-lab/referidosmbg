<?php

namespace App\Services;

use Telnyx\Telnyx;

class TelnyxService
{
    public function __construct()
    {
        Telnyx::setApiKey(env('TELNYX_API_KEY'));
    }

    /**
     * Enviar SMS con Telnyx
     */
    public function sendSms($to, $message,$form_number)
    {
        $response = \Telnyx\Message::create([
            'from' => $form_number,
            'to' => $to,
            'text' => $message,
            'messaging_profile_id' => env('TELNYX_MESSAGING_PROFILE_ID')
        ]);

        return $response;
    }

        /**
     * Consultar información de un número de teléfono (Number Lookup)
     */
    public function lookupNumber($phoneNumber)
    {
        try {
            $lookup = \Telnyx\NumberLookup::retrieve($phoneNumber);
            return $lookup;
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
