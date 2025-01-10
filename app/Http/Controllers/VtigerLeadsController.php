<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VtigerLead;

use App\Services\TextLinkSmsService;

class VtigerLeadsController extends Controller
{
    protected $textLinkSmsService;

    public function __construct(TextLinkSmsService $textLinkSmsService)
    {
        $this->textLinkSmsService = $textLinkSmsService;
    }

    public function index(){
        // Uso del scope
        $leads = VtigerLead::withCustomField('cf_853','like','%-01-9')->get();
        if(!empty($leads)){
            echo "No hay leads que cumplan años hoy.";
        }else{
            foreach ($leads as $lead) {
                echo "Lead ID: " . $lead->leadid . "<br>";
                echo "Nombre: " . $lead->firstname . " " . $lead->lastname . "<br>";
                echo "Campo CF937: " . $lead->customFields->cf_937 . "<br>";
                echo "Campo Birthday: " . $lead->customFields->cf_853 . "<br>";
                echo "Campo Plan: " . $lead->customFields->cf_865 . "<br>";
                // Acceder a otros campos...
            }
        }
    }

    public function sendSms(Request $request)
    {
        $request->validate([
            'to' => 'required|string',
            'message' => 'required|string|max:160',
        ]);

        $response = $this->textLinkSmsService->sendSms($request->to, $request->message);
        
        if (isset($response['ok']) && $response['ok']) {
            return response()->json(['message' => 'SMS enviado correctamente']);
        }

        return response()->json(['error' => $response['error'] ?? 'Error desconocido'], 500);
    }

}
