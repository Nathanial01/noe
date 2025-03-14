<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification as BaseNotification;
use Illuminate\Notifications\Messages\MailMessage;

class UserNotification extends BaseNotification implements ShouldQueue
{
    use Queueable;

    protected $messageText;

    /**
     * Create a new notification instance.
     *
     * @param string $messageText
     */
    public function __construct(string $messageText)
    {
        $this->messageText = $messageText;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail']; // Add 'database' if you want to store it as well.
    }

    /**
     * Build the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Notification from Your App')
            ->greeting("Hello, {$notifiable->first_name}!")
            ->line($this->messageText)
            ->action('View Users', url('/nova/resources/users'))
            ->line('Thank you for using our application!');
    }

    /**
     * (Optional) Get the array representation for database notifications.
     */
    public function toArray($notifiable)
    {
        return [
            'message' => $this->messageText,
        ];
    }
}
