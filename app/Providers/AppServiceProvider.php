<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router; // Import Router

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
