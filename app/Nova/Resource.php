<?php

namespace App\Nova;

use Illuminate\Http\Request as HttpRequest;            // For availableForNavigation
use Laravel\Nova\Http\Requests\NovaRequest;            // For indexQuery, detailQuery, etc.
use Illuminate\Contracts\Database\Eloquent\Builder;
use Laravel\Nova\Resource as NovaResource;

abstract class Resource extends NovaResource
{
    /**
     * Build an "index" query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder    $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        // Customize or filter the query if needed
        return $query;
    }

    /**
     * Build a Scout search query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Laravel\Scout\Builder                   $query
     * @return \Laravel\Scout\Builder
     */
    public static function scoutQuery(NovaRequest $request, $query)
    {
        // If using Laravel Scout, customize the query if needed
        return $query;
    }

    /**
     * Build a "detail" query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder    $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function detailQuery(NovaRequest $request, $query)
    {
        return parent::detailQuery($request, $query);
    }

    /**
     * Build a "relatable" query for the given resource.
     *
     * Determines which instances of the model may be attached to other resources.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder    $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function relatableQuery(NovaRequest $request, $query): Builder
    {
        return parent::relatableQuery($request, $query);
    }

    /**
     * Control whether this resource is displayed in the Nova sidebar.
     *
     * Must match parent's signature: availableForNavigation(\Illuminate\Http\Request $request): bool
     *
     * EXAMPLE: Show only to non-admin users by returning `true` if NOT admin.
     */
    public static function availableForNavigation(HttpRequest $request): bool
    {
        // Show resource in the sidebar only if user is NOT admin
        return !$request->user() || !$request->user()->is_admin;

        // If you want the opposite (show only to admin), do:
        // return $request->user() && $request->user()->is_admin;
    }
}
