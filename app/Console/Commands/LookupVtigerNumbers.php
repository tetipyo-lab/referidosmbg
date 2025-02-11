<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\VtigerLead;
use App\Models\VtigerLeadsCf;
use App\Services\TelnyxService;
use Illuminate\Support\Facades\Notification;
use App\Notifications\MailNotificarAdmins;

class LookupVtigerNumbers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:lookup-vtiger-numbers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cambiar el estado de los números desconectados en Vtiger';

    /**
     * Execute the console command.
     */
    public function handle(TelnyxService $telnyx)
    {
        $cantDesconectados = 0;
        $cantFijos = 0;
        $cantRecorridos = 0;

        \Log::info('Validando numeros en Telnyx: '.date('m-d-Y H:i:s'));
        $leads = VtigerLead::whereHas('customFields', function ($query) {
            $query->where('cf_855','=','TV')
            ->where('cf_997','=','0')
            ->where('leadstatus','=','CONTESTA OTRA PERSONA');
        })
        ->with(['address', 'customFields'])
        ->limit(1000)
        ->get();
        $cantRecorridos = $leads->count();

        if($cantRecorridos > 0){
            foreach($leads as $lead){
                $celular = $lead->address->mobile;
                $isFijo = $lead->customFields->cf_995;
                
                echo "Lead ID: " . $lead->leadid . "\n";
                echo "Telefono: " . $celular . "\n";
                echo "Nombre: " . $lead->firstname . " " . $lead->lastname . "\n";
                echo "Estado actual: " . $lead->leadstatus . "\n";

                if(!empty($celular) && strlen($celular) == 11){
                    echo "Numero Celular Válido \n";
                    //Consultar lookup número
                    $result = $telnyx->lookupNumber($celular);
                    $tipo = "";
                    $valido = false;
                    $callerName = "";
                    $isFijo = false;
                    $estado ="";
                    if(isset($result->valid_number)){
                        $valido = $result->valid_number;
                       
                        if(!empty($result->portability)){
                            $portability = $result->portability;
                            $tipo = $portability->line_type;
                            $estado = (!empty($portability->lrn)) ? "CONECTADO" : "TELEFONO DESCONECTADO";

                            if($tipo=="fixed line"){
                                $isFijo = true;
                                $cantFijos++;
                            }
                        }
                        if(!empty($result->caller_name)){
                            $cname = $result->caller_name;
                            $callerName = $cname->caller_name; 
                        }
                        $line = "$celular| $callerName | $tipo | $isFijo | $estado";
                        echo "$line\n";
                        \Log::info('Registro '.$line);
                        //Actualizar registro => cf_997, cf_995, leadstatus
                        $data = ["cf_997" => "1", "cf_995" => $isFijo];
                        $updCf = VtigerLeadsCf::where('leadid', $lead->leadid)
                        ->update($data);
                        if($updCf){
                            if($estado =="TELEFONO DESCONECTADO"){
                                $cantDesconectados++;
                                $updLead = VtigerLead::where('leadid',$lead->leadid)
                                ->update(["leadstatus" => $estado]);
                                if($updLead){
                                    echo "Telefono Desconectado detectado\n";
                                }
                            }
                            echo "Información del Lead Actualizada\n";
                        }
                    }else{
                        \Log::info('Error al consultar API');
                    }
                }
                echo ">>>>>>>>>>>>\n";
                sleep(rand(1,5));
            }
        }else{
            echo "No hay leads para ésta condicion\n";
            \Log::info('No hay leads para ésta condicion');
        }
        
        \Log::info('Fin del proceso de validacion: '.date('m-d-Y H:i:s'));
        \Log::info('Registros verificados:'.$cantRecorridos);
        \Log::info('Telefonos fijos: '.$cantFijos);
        \Log::info('Telefonos desconectados: '.$cantDesconectados);
        $this->correoNotificacion($cantRecorridos,$cantFijos,$cantDesconectados);
    }

    private function correoNotificacion($cantRecorridos,$cantFijos,$cantDesconectados){
        $body = "
        Fin del proceso de validacion: ".date("Y-m-d H:i:s")."\n\n
        Registros verificados: $cantRecorridos\n
        Telefonos fijos: $cantFijos\n
        Telefonos desconectados: $cantDesconectados";

        try {
            $detalle = [
                'asunto' => 'Verificación de números Leads - Lookup Numbers Telnyx',
                'mensaje' => $body
            ];
            Notification::route('mail', [
                'insfranjosealfredo@gmail.com',
                'mbgroup.insurance@gmail.com',
                'mariobarreraruiz@gmail.com',
            ])->notify(new MailNotificarAdmins($detalle));
        } catch (\Exception $e) {
            \Log::error('Error al enviar el correo: ' . $e->getMessage());
        }
        
    }
}
