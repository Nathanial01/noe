<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Laravel\Fortify\Features;
use Laravel\Nova\Dashboard;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Illuminate\Http\Request;
use Laravel\Nova\Tool;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        parent::boot();

        // Example custom footer
        Nova::footer(function (Request $request) {
            return Blade::render('
                @env("production")
                    This is production!
                @endenv
            ');
        });
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
     * If user is admin => show [Main, Clients].
     * Otherwise => show [Clients].
     *
     * @return array<int, Dashboard>
     */
    protected function dashboards(): array
    {
        $user = request()->user();

        if ($user && $user->is_admin) {
            return [
                new \App\Nova\Dashboards\Main,
                new \App\Nova\Dashboards\Clients,
            ];
        }

        // Non-admin users only see the Clients dashboard
        return [
            new \App\Nova\Dashboards\Clients,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array<int, Tool>
     */
    public function tools(): array
    {
        return [];
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        parent::register();
    }
}
