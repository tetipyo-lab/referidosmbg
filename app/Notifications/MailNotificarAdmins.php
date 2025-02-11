<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MailNotificarAdmins extends Notification
{
    use Queueable;

    public $detalle;

    public function __construct($detalle)
    {
        $this->detalle = $detalle;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        if (empty($this->detalle['asunto']) || empty($this->detalle['mensaje'])) {
            throw new \InvalidArgumentException('El asunto y mensaje son requeridos');
        }

        return (new MailMessage)
            ->subject($this->detalle['asunto'])
            ->markdown('emails.mensaje', [
                'asunto' => $this->detalle['asunto'],
                'mensaje' => $this->detalle['mensaje'],
            ]);
    }
}
