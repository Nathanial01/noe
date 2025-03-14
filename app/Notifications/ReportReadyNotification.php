<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Laravel\Nova\Notifications\NovaChannel;
use Laravel\Nova\Notifications\NovaNotification;
use Laravel\Nova\URL;
use Illuminate\Notifications\Messages\MailMessage;

class ReportReadyNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function via($notifiable): array
    {
        return [NovaChannel::class, 'mail'];
    }

    public function toNova($notifiable)
    {
        return NovaNotification::make()
            ->message('Your report is ready to download.')
            ->action('Download', URL::remote('https://example.com/report.pdf'))
            ->openInNewTab()
            ->icon('download')
            ->type('info');
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Report Ready')
            ->line('Your report is ready to download.')
            ->action('Download', url('https://example.com/report.pdf'))
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => 'Your report is ready to download.',
            'action'  => URL::remote('https://example.com/report.pdf'),
        ];
    }
}
