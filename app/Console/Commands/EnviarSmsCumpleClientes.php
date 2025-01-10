<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\VtigerLead;

class EnviarSmsCumpleClientes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:felicitar-clientes';
    protected $description = 'Enviar sms de felicitaciones automáticamente todos los días';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        \Log::info('Correo diario enviado.');
        $fecha = date('m-d');
        //where('leadstatus', 'APROBADO')
        $leads = VtigerLead::whereHas('customFields', function ($query) {
            $query->where('cf_853', 'like', '%-03-10');
        })
        ->with(['address', 'customFields'])
        ->get();
        
        if(empty($leads)){
            echo "No hay leads que cumplan años hoy.";  
        }else{
            foreach ($leads as $lead) {
                echo "Lead ID: " . $lead->leadid . "\n";
                echo "Lead STATUS: " . $lead->leadstatus . "\n";
                echo "Nombre: " . $lead->firstname . " " . $lead->lastname . "\n";
                echo "Campo CF937: " . $lead->customFields->cf_937 . "\n";
                echo "Campo Birthday: " . $lead->customFields->cf_853 . "\n";
                echo "Campo Plan: " . $lead->customFields->cf_865 . "\n";
                echo "======>>>>>\n";
                // Acceder a otros campos...
            }
        }
    }
}
