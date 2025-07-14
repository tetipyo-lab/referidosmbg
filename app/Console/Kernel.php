<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\EnviarSmsCumpleClientes::class,
        \App\Console\Commands\ProcessDncFiles::class,
    ];
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        //Enviar felicitacion Clientes - Mario
        $schedule->command('sms:felicitar-clientes-mario')->dailyAt('09:00');
        //$schedule->command('app:lookup-vtiger-numbers')->dailyAt('02:00');
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
