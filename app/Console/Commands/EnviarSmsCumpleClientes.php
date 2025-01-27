<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\VtigerLead;
use App\Services\TextLinkSmsService;

class EnviarSmsCumpleClientes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:felicitar-clientes-mario';
    protected $description = 'Enviar sms de felicitaciones automáticamente todos los días';
    protected $textLinkSmsService;

   /* public function __construct(TextLinkSmsService $textLinkSmsService)
    {
        $this->textLinkSmsService = $textLinkSmsService;
    }*/
    /**
     * Execute the console command.
     */
    public function handle(TextLinkSmsService $textLinkSmsService)
    {
        $this->textLinkSmsService = $textLinkSmsService;
        \Log::info('Correo diario enviado.');
        $leads = VtigerLead::whereHas('customFields', function ($query) {
            $query->where('cf_853', 'like', '%-'.date('m-d'))
            ->where('cf_935','=','739694')
            ->where('leadstatus','=','APROBADO');
        })
        ->with(['address', 'customFields'])
        ->get();
        
        if($leads->isEmpty()){
            echo "No hay leads que cumplan años hoy.";
            \Log::info('Correo diario enviado.');
        }else{
            
            foreach ($leads as $lead) {
                $prNombre = explode(" ",$lead->firstname)[0] ?? 'Hola';
                $phoneDst = $lead->address->mobile;
                //$phoneDst = "14697339666";
                echo "Lead ID: " . $lead->leadid . "\n";
                echo "Lead STATUS: " . $lead->leadstatus . "\n";
                echo "Nombre: " . $lead->firstname . " " . $lead->lastname . "\n";
                echo "Campo Birthday: " . $lead->customFields->cf_853 . "\n";
                echo "Telefono: " . $phoneDst . "\n";
                echo "Email: " . $lead->email . "\n";
                echo "======>>>>>\n";
                if(strlen($phoneDst) > 10){
                    $textoSms = $prNombre."\nEn éste día especial quiero felicitarte por un año más de vida. Tu agente de aseguranzas Mario Barrera.";
                    $response = $this->textLinkSmsService->sendSms("+".$phoneDst, $textoSms);
                    \Log::info('Texto Felicitacion: '.$textoSms);
                    if (isset($response['ok']) && $response['ok']) {
                        \Log::info('SMS envaido correctamente.');
                    }else{
                        \Log::info('Falló envío de SMS.');
                    }
                }
            }
        }
    }
}
