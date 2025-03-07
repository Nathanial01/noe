<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\web\AboutController;
use App\Http\Controllers\web\AgendaEvent\AgendaEventController;
use App\Http\Controllers\web\ContactController;
use App\Http\Controllers\web\Masterclass\MasterclassController;
use App\Http\Controllers\web\PrivateEquityController;
use App\Http\Controllers\web\RealEstateController;
use App\Http\Controllers\web\Webinar\WebinarController;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PageController extends Controller
{
    /**
     * Render a static page dynamically.
     */
    public function renderPage(string $page): Response
    {
        // Normalize page parameter to lowercase for consistency
        $page = strtolower($page);

        // Log the requested page for debugging
        Log::debug("Rendering page: " . $page);

        return match ($page) {
            'private-equity' => app(PrivateEquityController::class)->index(),
            'contact'         => app(ContactController::class)->index(),
            'real-estate'     => app(RealEstateController::class)->index(),
            'about'           => app(AboutController::class)->index(),
            'agendaevent'     => app(AgendaEventController::class)->index(),
            'webinar'         => app(WebinarController::class)->index(),
            'masterclass'     => app(MasterclassController::class)->index(),
            default           => abort(404, "Page not found: " . $page),
        };
    }

    /**
     * Handle form store dynamically.
     */
    public function store(Request $request, string $page)
    {
        $page = strtolower($page);
        Log::debug("Storing data for page: " . $page);

        return match ($page) {
            'private-equity' => app(PrivateEquityController::class)->store($request),
            'contact'         => app(ContactController::class)->store($request),
            'real-estate'     => app(RealEstateController::class)->store($request),
            'agendaevent'     => app(AgendaEventController::class)->store($request),
            'webinar'         => app(WebinarController::class)->store($request),
            'masterclass'     => app(MasterclassController::class)->store($request),
            default           => abort(404),
        };
    }

    /**
     * Show specific item.
     */
    public function show(string $page, int $id): Response
    {
        $page = strtolower($page);
        Log::debug("Showing item from page: " . $page . ", id: " . $id);

        return match ($page) {
            'private-equity' => app(PrivateEquityController::class)->show($id),
            'contact'         => app(ContactController::class)->show($id),
            'real-estate'     => app(RealEstateController::class)->show($id),
            'agendaevent'     => app(AgendaEventController::class)->show($id),
            'webinar'         => app(WebinarController::class)->show($id),
            'masterclass'     => app(MasterclassController::class)->show($id),
            default           => abort(404),
        };
    }

    /**
     * Edit item dynamically.
     */
    public function edit(string $page, int $id): Response
    {
        $page = strtolower($page);
        Log::debug("Editing item from page: " . $page . ", id: " . $id);

        return match ($page) {
            'private-equity' => app(PrivateEquityController::class)->edit($id),
            'contact'         => app(ContactController::class)->edit($id),
            'real-estate'     => app(RealEstateController::class)->edit($id),
            'agendaevent'     => app(AgendaEventController::class)->edit($id),
            'webinar'         => app(WebinarController::class)->edit($id),
            'masterclass'     => app(MasterclassController::class)->edit($id),
            default           => abort(404),
        };
    }

    /**
     * Update an item dynamically.
     */
    public function update(Request $request, string $page, int $id)
    {
        $page = strtolower($page);
        Log::debug("Updating item from page: " . $page . ", id: " . $id);

        return match ($page) {
            'private-equity' => app(PrivateEquityController::class)->update($request, $id),
            'contact'         => app(ContactController::class)->update($request, $id),
            'real-estate'     => app(RealEstateController::class)->update($request, $id),
            'agendaevent'     => app(AgendaEventController::class)->update($request, $id),
            'webinar'         => app(WebinarController::class)->update($request, $id),
            'masterclass'     => app(MasterclassController::class)->update($request, $id),
            default           => abort(404),
        };
    }

    /**
     * Delete an item dynamically.
     */
    public function destroy(string $page, int $id)
    {
        $page = strtolower($page);
        Log::debug("Deleting item from page: " . $page . ", id: " . $id);

        return match ($page) {
            'private-equity' => app(PrivateEquityController::class)->destroy($id),
            'contact'         => app(ContactController::class)->destroy($id),
            'real-estate'     => app(RealEstateController::class)->destroy($id),
            'agendaevent'     => app(AgendaEventController::class)->destroy($id),
            'webinar'         => app(WebinarController::class)->destroy($id),
            'masterclass'     => app(MasterclassController::class)->destroy($id),
            default           => abort(404),
        };
    }
}
