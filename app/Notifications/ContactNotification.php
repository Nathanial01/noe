<?php

namespace App\Notifications;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ContactNotification extends Notification
{
    use Queueable;

    public $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function via($notifiable)
    {
        // Use only the mail channel.
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nieuw Contactbericht')
            ->greeting("Hallo {$notifiable->name},")
            ->line("Er is een nieuw contactformulier ingediend door {$this->contact->first_name}.")
            ->line("E-mail: {$this->contact->email}")
            ->line("Bericht: {$this->contact->message}")
            ->action('Bekijk bericht', url('/nova/resources/contacts'))
            ->line('Bedankt voor het gebruiken van onze applicatie!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "Nieuw contactbericht van {$this->contact->first_name}.",
            'link'    => url('/nova/resources/contacts'),
        ];
    }
}
