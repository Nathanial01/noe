<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class UserNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $messageContent;

    /**
     * Create a new message instance.
     *
     * @param \App\Models\User $user
     * @param string $messageContent
     */
    public function __construct(User $user, $messageContent)
    {
        $this->user = $user;
        $this->messageContent = $messageContent;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject('Important Notification from ' . config('app.name'))
            ->view('emails.user_notification')
            ->with([
                'user'          => $this->user,
                'customMessage' => $this->messageContent,
            ]);
    }
}
