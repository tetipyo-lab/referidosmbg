<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeadsEjecucionMarcarDnc extends Mailable
{
    use Queueable, SerializesModels;

    public $actualizados;
    public $leidos;
    public $noActualizados;

    public function __construct($leidos, $actualizados, $noActualizados,$nrosInvalidos)
    {
        $this->leidos = $leidos;
        $this->actualizados = $actualizados;
        $this->noActualizados = $noActualizados;
        $this->nrosInvalidos = $nrosInvalidos;
    }

    public function build()
    {
        return $this->subject('Resumen de ejecución - Actualización DNC de Leads')
                    ->view('emails.leadsEjecucionMarcarDnc');
    }
}
