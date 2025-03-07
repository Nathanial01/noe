<?php

namespace App\Nova;

use Illuminate\Http\Request as HttpRequest;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Laravel\Nova\Resource as NovaResource;
use MongoDB\Laravel\Auth\User as Authenticatable;

abstract class Resource extends NovaResource
{
    // Force MongoDB connection for all resources.
    protected $connection = 'mongodb';

    // Each resource must define its collection name.
    protected string $collection = '';

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query;
    }

    public static function scoutQuery(NovaRequest $request, $query)
    {
        return $query;
    }

    public static function detailQuery(NovaRequest $request, $query)
    {
        return parent::detailQuery($request, $query);
    }

    public static function relatableQuery(NovaRequest $request, $query): Builder
    {
        return parent::relatableQuery($request, $query);
    }

    /**
     * Control whether this resource appears in the Nova sidebar.
     * (Adjust logic as needed: here, it shows only for non-admins.)
     */
    public static function availableForNavigation(HttpRequest $request): bool
    {
        // Example: show only when user is not admin.
        return !$request->user() || !$request->user()->is_admin;
        // Alternatively, to show only to admin:
        // return $request->user() && $request->user()->is_admin;
    }
}
