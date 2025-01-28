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

    /**
     * Execute the console command.
     */
    public function handle(TextLinkSmsService $textLinkSmsService)
    {
        $this->textLinkSmsService = $textLinkSmsService;
        \Log::info('Verificando cumpleaños: '.date('m-d'));
        $leads = VtigerLead::whereHas('customFields', function ($query) {
            $query->where('cf_853', 'like', '%-'.date('m-d'))
            ->where('cf_935','=','739694')
            ->where('leadstatus','=','APROBADO');
        })
        ->with(['address', 'customFields'])
        ->get();
        
        if($leads->isEmpty()){
            echo "No hay Clientes que cumplan años hoy.";
            \Log::info('No hay Clientes que cumplan años hoy.');
        }else{
            
            foreach ($leads as $lead) {
                $prNombre = explode(" ",$lead->firstname)[0] ?? 'Hola';
                $phoneDst = $lead->address->mobile;

                if(strlen($phoneDst) > 10){
                    $textoSms = $prNombre." hola, soy Mario Barrera tu agente de aseguranza. Quiero desearte todo lo mejor en tu dia, clic aqui para escuchar mis felicitaciones: https://linke.to/hbirthday\n
                    1 para mas informacion.\n
                    STOP to cancel SMS.";
                    
                    $response = $this->textLinkSmsService->sendSms("+".$phoneDst, $textoSms);
                    \Log::info('Texto Felicitacion: '.$textoSms);
                    if (isset($response['ok']) && $response['ok']) {
                        \Log::info('SMS envaido correctamente a '.$lead->firstname . " " . $lead->lastname." $phoneDst.");
                    }else{
                        \Log::info('Falló envío de SMS.');
                    }
                }else{
                    \Log::info("Numero con formato invalido: $phoneDst");
                }
            }
        }
    }
}
