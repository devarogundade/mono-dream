<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketPurchased extends Notification implements ShouldQueue
{
    use Queueable;

    public $ticket;

    public function __construct($userticket)
    {
        $this->ticket = $userticket->ticket;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('You just bought a ticket.')
                    ->line('Title: ' . $this->ticket->title)
                    ->line('Amount: NGN' . $this->ticket->amount)
                    ->line('Schedule: ' . $this->ticket->schedule)
                    ->line('Ticket code : DREAM' . $this->ticket->id)
                    ->action('View ticket', url('/'))
                    ->line('Thank you for using dream!');
    }

}
