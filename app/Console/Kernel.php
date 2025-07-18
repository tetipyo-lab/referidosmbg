<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\EnviarSmsCumpleClientes::class,
        //\App\Console\Commands\ProcessDncFiles::class,
        \App\Console\Commands\VtigerMarcarDNC::class
    ];
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        //Enviar felicitacion Clientes - Mario
        $schedule->command('sms:felicitar-clientes-mario')->dailyAt('09:00');
        $schedule->command('vtiger:dnc-marcar --limit=20000')->dailyAt('01:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
