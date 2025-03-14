<?php

namespace App\Nova;

use App\Nova\Actions\SendNotification;
use App\Nova\Actions\NotifyAllUsers; // Our custom action, if used
use Illuminate\Http\Request;
use App\Models\User as UserModel; // Alias the model
use KirschbaumDevelopment\NovaMail\Actions\SendMail;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Email;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;
use App\Nova\Metrics\NewUsers;       // Your existing value metric for new users
use App\Nova\Metrics\UserTrend;        // Your trend metric for user growth
use App\Nova\Metrics\UserPortfolioDistribution; // New portfolio metric
use Throwable;

class User extends Resource
{
    public static $model = UserModel::class;
    public static $title = 'email';
    public static $search = ['id', 'first_name', 'last_name', 'email'];

    public static function uriKey()
    {
        return 'user-resource';
    }

    /**
     * Override the menu to show a badge for new users (created in the last 7 days).
     */
    git public function menu(Request $request)
    {
        return parent::menu($request)->withBadge(function () {
            try {
                // Count users created within the last 7 days.
                return static::$model::where('created_at', '>=', now()->subDays(7))->count();
            } catch (Throwable $e) {
                return 0;
            }
        });
    }

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('First Name', 'first_name')->sortable(),
            Text::make('Last Name', 'last_name')->sortable(),
            Email::make('Email')->sortable(),
            Boolean::make('Is Admin', 'is_admin'),
            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:8')
                ->updateRules('nullable', 'string', 'min:8'),
        ];
    }

    public function actions(NovaRequest $request)
    {
        return [
            new SendMail(),          // NovaMail's default send mail action
            new SendNotification(),  // Your custom notification action
        ];
    }

    public function cards(NovaRequest $request): array
    {
        return [
            new NewUsers,                  // Your existing new users metric
            new UserTrend,                 // Graphical trend metric (user registrations over time)
            new UserPortfolioDistribution, // Partition metric for user portfolio amounts
        ];
    }
}
