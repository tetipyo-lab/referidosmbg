<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\VtigerLead;
use App\Services\TelnyxService;

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
    public function handle()
    {
        //
        \Log::info('Validando numeros en Telnyx: '.date('m-d'));
        $leads = VtigerLead::whereHas('customFields', function ($query) {
            $query->where('cf_855','=','TV');
        })
        ->with(['address', 'customFields'])
        ->get();
        echo count($leads);
        //print_r($leads);
        \Log::info('Fin del proceso de validacion: '.date('m-d'));
    }
}
