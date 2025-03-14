<?php

namespace App\Providers;

use App\Observers\UserObserver;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use App\Models\User as EloquentUser;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(Router $router): void
    {
        // Register the observer on the Eloquent User model.
        EloquentUser::observe(UserObserver::class);

        // Register the mail namespace so Laravel can find custom email templates.
        View::addNamespace('mail', resource_path('views/mail'));

        // Prefetch assets using Vite with a concurrency limit.
        Vite::prefetch(concurrency: 3);

        // Force HTTPS in production.
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // Register the 'admin' middleware alias if not already registered in the Kernel.
        $router->aliasMiddleware('admin', \App\Http\Middleware\IsAdmin::class);
    }
}
