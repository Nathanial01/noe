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
        $page = strtolower($page);
        Log::debug("Rendering page: " . $page);

        // List of valid controllers mapped to page names
        $controllers = [
            'private-equity' => PrivateEquityController::class,
            'contact' => ContactController::class,
            'real-estate' => RealEstateController::class,
            'about' => AboutController::class,
            'agendaevent' => AgendaEventController::class,
            'webinar' => WebinarController::class,
            'masterclass' => MasterclassController::class,
        ];

        // Validate if page exists in the array
        if (!isset($controllers[$page])) {
            Log::error("Page not found: " . $page);
            abort(404, "Page not found: " . $page);
        }

        $controller = app($controllers[$page]);

        // Ensure the controller has an `index()` method
        if (!method_exists($controller, 'index')) {
            Log::error("Method `index()` missing in " . get_class($controller));
            abort(500, "Method `index()` missing in " . get_class($controller));
        }

        return $controller->index();
    }

    /**
     * Store form data dynamically.
     */
    public function store(Request $request, string $page)
    {
        $page = strtolower($page);
        Log::debug("Storing data for page: " . $page);

        $controllers = [
            'private-equity' => PrivateEquityController::class,
            'contact' => ContactController::class,
            'real-estate' => RealEstateController::class,
            'agendaevent' => AgendaEventController::class,
            'webinar' => WebinarController::class,
            'masterclass' => MasterclassController::class,
        ];

        if (!isset($controllers[$page])) {
            abort(404);
        }

        $controller = app($controllers[$page]);

        if (!method_exists($controller, 'store')) {
            abort(500, "Method `store()` missing in " . get_class($controller));
        }

        return $controller->store($request);
    }

    /**
     * Show specific item dynamically.
     */
    public function show(string $page, int $id): Response
    {
        $page = strtolower($page);
        Log::debug("Showing item from page: " . $page . ", id: " . $id);

        $controllers = [
            'private-equity' => PrivateEquityController::class,
            'contact' => ContactController::class,
            'real-estate' => RealEstateController::class,
            'agendaevent' => AgendaEventController::class,
            'webinar' => WebinarController::class,
            'masterclass' => MasterclassController::class,
        ];

        if (!isset($controllers[$page])) {
            abort(404);
        }

        $controller = app($controllers[$page]);

        if (!method_exists($controller, 'show')) {
            abort(500, "Method `show()` missing in " . get_class($controller));
        }

        return $controller->show($id);
    }

    /**
     * Edit an item dynamically.
     */
    public function edit(string $page, int $id): Response
    {
        $page = strtolower($page);
        Log::debug("Editing item from page: " . $page . ", id: " . $id);

        $controllers = [
            'private-equity' => PrivateEquityController::class,
            'contact' => ContactController::class,
            'real-estate' => RealEstateController::class,
            'agendaevent' => AgendaEventController::class,
            'webinar' => WebinarController::class,
            'masterclass' => MasterclassController::class,
        ];

        if (!isset($controllers[$page])) {
            abort(404);
        }

        $controller = app($controllers[$page]);

        if (!method_exists($controller, 'edit')) {
            abort(500, "Method `edit()` missing in " . get_class($controller));
        }

        return $controller->edit($id);
    }

    /**
     * Update an item dynamically.
     */
    public function update(Request $request, string $page, int $id)
    {
        $page = strtolower($page);
        Log::debug("Updating item from page: " . $page . ", id: " . $id);

        $controllers = [
            'private-equity' => PrivateEquityController::class,
            'contact' => ContactController::class,
            'real-estate' => RealEstateController::class,
            'agendaevent' => AgendaEventController::class,
            'webinar' => WebinarController::class,
            'masterclass' => MasterclassController::class,
        ];

        if (!isset($controllers[$page])) {
            abort(404);
        }

        $controller = app($controllers[$page]);

        if (!method_exists($controller, 'update')) {
            abort(500, "Method `update()` missing in " . get_class($controller));
        }

        return $controller->update($request, $id);
    }

    /**
     * Delete an item dynamically.
     */
    public function destroy(string $page, int $id)
    {
        $page = strtolower($page);
        Log::debug("Deleting item from page: " . $page . ", id: " . $id);

        $controllers = [
            'private-equity' => PrivateEquityController::class,
            'contact' => ContactController::class,
            'real-estate' => RealEstateController::class,
            'agendaevent' => AgendaEventController::class,
            'webinar' => WebinarController::class,
            'masterclass' => MasterclassController::class,
        ];

        if (!isset($controllers[$page])) {
            abort(404);
        }

        $controller = app($controllers[$page]);

        if (!method_exists($controller, 'destroy')) {
            abort(500, "Method `destroy()` missing in " . get_class($controller));
        }

        return $controller->destroy($id);
    }
}
