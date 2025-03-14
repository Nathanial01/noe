<?php

namespace App\Providers;

use App\Observers\UserObserver;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Laravel\Nova\Dashboard;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Illuminate\Http\Request;
use App\Models\Notification;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register the Notification observer on your custom Notification model
        Notification::observe(UserObserver::class);

        // Disable Nova's action event logging to avoid SQL errors
        Nova::actionEvent(fn () => null);

        // Enable the unread notifications count in Nova's notification center
        Nova::showUnreadCountInNotificationCenter();

        // Example custom footer for Nova
        Nova::footer(function (Request $request) {
            return Blade::render(<<<'HTML'
                @env("production")
                    This is production!
                @endenv
HTML);
        });

        // Call the parent boot method last
        parent::boot();
    }

    /**
     * Register the configurations for Laravel Fortify.
     */
    protected function fortify(): void
    {
        Nova::fortify()
            ->features([
                Features::updatePasswords(),
                // Features::emailVerification(),
                // Features::twoFactorAuthentication(["confirm" => true, "confirmPassword" => true]),
            ])
            ->register();
    }

    /**
     * Register the Nova routes.
     */
    protected function routes(): void
    {
        Nova::routes()
            ->withAuthenticationRoutes(default: true)
            ->withPasswordResetRoutes()
            ->withoutEmailVerificationRoutes()
            ->register();

        // (Optional) Override Nova's notifications endpoint if you want custom behavior.
        // If you prefer to use Nova's native notifications handling, you can remove this route.
        Route::get('/nova-api/notifications', function (Request $request) {
            return response()->json(
                auth()->user()->notifications()->orderBy('created_at', 'desc')->get()
            );
        });
    }

    /**
     * Global Nova Gate: Allow any authenticated user to access Nova.
     */
    protected function gate(): void
    {
        Gate::define('viewNova', function ($user) {
            return $user !== null;
        });
    }

    /**
     * Determine which dashboards are displayed in the Nova sidebar.
     *
     * If user is admin => show [Main, Clients]. Otherwise, show [Clients].
     *
     * @return array<int, Dashboard>
     */
    protected function dashboards(): array
    {
        $user = request()->user();

        return $user && $user->is_admin
            ? [new \App\Nova\Dashboards\Main, new \App\Nova\Dashboards\Clients]
            : [new \App\Nova\Dashboards\Clients];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array<int, \Laravel\Nova\Tool>
     */
    public function tools(): array
    {
        return [
            // Register any custom Nova tools here, if needed.
        ];
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        parent::register();
    }
}
