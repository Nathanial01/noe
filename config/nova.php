<?php

use Laravel\Nova\Actions\ActionResource;
use Laravel\Nova\Http\Middleware\Authenticate;
use Laravel\Nova\Http\Middleware\Authorize;
use Laravel\Nova\Http\Middleware\BootTools;
use Laravel\Nova\Http\Middleware\DispatchServingNovaEvent;
use Laravel\Nova\Http\Middleware\HandleInertiaRequests;

return [

    /*
    |--------------------------------------------------------------------------
    | Customize the Logo
    |--------------------------------------------------------------------------
    |
    | To customize the logo used at the top left of the Nova interface, you may
    | specify the configuration below.
    |
    */
    'brand' => [
        'logo' => resource_path('/img/SVGS/logo.svg'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Nova License Key
    |--------------------------------------------------------------------------
    */
    'license_key' => env('NOVA_LICENSE_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Nova App Name
    |--------------------------------------------------------------------------
    */
    'name' => env('NOVA_APP_NAME', env('APP_NAME')),

    /*
    |--------------------------------------------------------------------------
    | Nova Domain Name
    |--------------------------------------------------------------------------
    */
    'domain' => env('NOVA_DOMAIN_NAME', null),

    /*
    |--------------------------------------------------------------------------
    | Nova Path
    |--------------------------------------------------------------------------
    */
    'path' => '/nova',

    /*
    |--------------------------------------------------------------------------
    | Nova Authentication Guard
    |--------------------------------------------------------------------------
    */
    'guard' => env('NOVA_GUARD', null),

    /*
    |--------------------------------------------------------------------------
    | Nova Password Reset Broker
    |--------------------------------------------------------------------------
    */
    'passwords' => env('NOVA_PASSWORDS', null),

    /*
    |--------------------------------------------------------------------------
    | Nova Route Middleware
    |--------------------------------------------------------------------------
    */
    'middleware' => [
        'web',
        HandleInertiaRequests::class,
        DispatchServingNovaEvent::class,
        BootTools::class,
    ],

    'api_middleware' => [
        'nova',
        Authenticate::class,
        Authorize::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Nova Pagination Type
    |--------------------------------------------------------------------------
    |
    | Change the pagination type to "links" to display full pagination controls,
    | including next and previous page buttons.
    |
    */
    'pagination' => 'links',

    /*
    |--------------------------------------------------------------------------
    | Nova Storage Disk
    |--------------------------------------------------------------------------
    |
    | This configuration option allows you to define the default disk that
    | will be used to store files using the Image, File, and other file
    | related field types.
    |
    */
    'storage_disk' => env('NOVA_STORAGE_DISK', 'public'),

    /*
    |--------------------------------------------------------------------------
    | Nova Currency
    |--------------------------------------------------------------------------
    |
    | This configuration option allows you to define the default currency
    | used by the Currency field within Nova.
    |
    */
    'currency' => 'USD',

    /*
    |--------------------------------------------------------------------------
    | Nova Action Resource Class
    |--------------------------------------------------------------------------
    |
    | This configuration option allows you to specify a custom resource class
    | to use for action log entries.
    |
    */
    'actions' => [
        'resource' => ActionResource::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Nova Impersonation Redirection URLs
    |--------------------------------------------------------------------------
    |
    | This configuration option allows you to specify a URL where Nova should
    | redirect after impersonating a user.
    |
    */
    'impersonation' => [
        'started' => '/',
        'stopped' => '/',
    ],

    /*
    |--------------------------------------------------------------------------
    | Nova User Resource
    |--------------------------------------------------------------------------
    |
    | This option defines the resource that should be used to represent your
    | users within Nova. Make sure you replace the default with your custom resource.
    |
    */
    'user' => \App\Nova\User::class,
];
