<?php

namespace App\Notifications;

use App\Models\Ticket;
use App\Models\TicketResponse;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewTicketResponseNotification extends Notification
{
    use Queueable;

    /**
     * @var \App\Models\Ticket
     */
    private Ticket $ticket;
    /**
     * @var \App\Models\TicketResponse
     */
    private TicketResponse $ticketResponse;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Ticket $ticket, TicketResponse $ticketResponse)
    {
        $this->ticket = $ticket;
        $this->ticketResponse = $ticketResponse;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param \App\Models\User|mixed $notifiable
     *
     * @return array
     */
    public function via(mixed $notifiable): array
    {
        // User doesn't need to know about a comment of itself.
        if ($notifiable->id === $this->ticketResponse->author_id) {
            return [];
        }

        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param \App\Models\User|mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail(mixed $notifiable): MailMessage
    {
        return (new MailMessage())
            ->greeting('Hello '.$notifiable->full_name.'!')
            ->line($this->ticketResponse->author->full_name.' has left a response to your ticket '.$this->ticket->title.'.')
            ->action('See response', url('/tickets/'.$this->ticket->id));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param \App\Models\User|mixed $notifiable
     *
     * @return array
     */
    public function toArray(mixed $notifiable): array
    {
        return [
            //
        ];
    }
}
