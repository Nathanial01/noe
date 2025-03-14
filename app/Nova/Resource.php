<?php

namespace App\Nova;

use App\Nova\Actions\NotifyAllUsers;
use App\Nova\Actions\SendNotification;
use KirschbaumDevelopment\NovaMail\Actions\SendMail;
use Illuminate\Http\Request as HttpRequest;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Resource as NovaResource;

abstract class Resource extends NovaResource
{
    /**
     * Customize the index query.
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query;
    }

    /**
     * Customize the scout query.
     */
    public static function scoutQuery(NovaRequest $request, $query)
    {
        return $query;
    }

    /**
     * Customize the detail query.
     */
    public static function detailQuery(NovaRequest $request, $query)
    {
        return parent::detailQuery($request, $query);
    }

    /**
     * Customize the relatable query.
     */
    public static function relatableQuery(NovaRequest $request, $query): Builder
    {
        return parent::relatableQuery($request, $query);
    }

    /**
     * Control whether this resource appears in the Nova sidebar.
     */
    public static function availableForNavigation(HttpRequest $request): bool
    {
        // Example: show only for non-admin users.
        return !$request->user() || !$request->user()->is_admin;
        // Alternatively, to show only for admins, you could use:
        // return $request->user() && $request->user()->is_admin;
    }

    /**
     * Return the available actions for the resource.
     */
    public function actions(NovaRequest $request): array
    {
        return [
            new SendMail,
            new SendNotification,

        ];
    }
}
