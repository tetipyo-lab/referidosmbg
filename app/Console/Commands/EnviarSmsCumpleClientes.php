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
    }
}
