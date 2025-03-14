<?php

namespace App\Nova\Actions;

use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Notifications\UserNotification;

class SendNotification extends Action
{
    public $name = 'Send Notification';

    /**
     * Execute the action on the given models.
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $user) {
            // Use Laravel's notification system to send an email notification.
            $user->notify(new UserNotification($fields->message));
        }

        return Action::message('Notification sent successfully!');
    }

    /**
     * Get the fields available on the action.
     */
    public function fields(NovaRequest $request)
    {
        return [
            Select::make('Type')->options([
                'info'    => 'Info',
                'warning' => 'Warning',
                'success' => 'Success',
            ])->rules('required'),
            Textarea::make('Message')->rules('required'),
        ];
    }
}
