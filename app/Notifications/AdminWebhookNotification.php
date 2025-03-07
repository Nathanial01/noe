<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminWebhookNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected \Throwable $th;

    /**
     * Create a new notification instance.
     *
     * @param \Throwable $th
     * @return void
     */
    public function __construct(\Throwable $th)
    {
        $this->th = $th;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        $appName = config('app.name');

        return (new MailMessage)
            ->subject("{$appName}: Mollie webhook failed")
            ->line('The Mollie webhook failed with the following message:')
            ->line('Message: ' . $this->th->getMessage())
            ->line('File: ' . $this->th->getFile())
            ->line('Line: ' . $this->th->getLine())
            ->line('Trace:')
            ->line($this->th->getTraceAsString());
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable): array
    {
        return [
            'message' => $this->th->getMessage(),
            'file'    => $this->th->getFile(),
            'line'    => $this->th->getLine(),
            'trace'   => $this->th->getTraceAsString(),
        ];
    }
}
