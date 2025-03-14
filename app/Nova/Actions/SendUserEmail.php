<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendUserEmail extends Action implements ShouldQueue
{
    use Queueable;
    public $name = 'Send Email to Selected Users';

    public function authorizedToRun(NovaRequest|\Illuminate\Http\Request $request, $model)
    {
        return $request->user()->is_admin;
    }

    public function handle(ActionFields $fields, Collection $models)
    {
        Log::info('Nova Action Triggered: SendUserEmail');

        foreach ($models as $user) {
            Log::info('Processing user: ' . $user->email);

            if (!filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
                Log::warning('Invalid email for user: ' . $user->id);
                continue;
            }

            try {
                Mail::to($user->email)->send(new UserNotificationMail($user, $fields->custom_message));
                Log::info('Email sent to: ' . $user->email);
            } catch (\Exception $e) {
                Log::error('Error sending email to ' . $user->email . ': ' . $e->getMessage());
                return Action::danger('Failed to send email to some users. Please check logs.');
            }
        }

        Log::info('Nova Email Action Completed');
        return Action::message('Emails sent successfully!');
    }

    public function fields(NovaRequest $request)
    {
        return [
            Textarea::make('Custom Message', 'custom_message')
                ->rules('required', 'string')
                ->help('Enter the message to include in the email.'),
        ];
    }
}
