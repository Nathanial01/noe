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
     * Map page slugs to their corresponding controller classes.
     *
     * @var array
     */
    protected array $controllers = [
        'private-equity' => \App\Http\Controllers\web\PrivateEquityController::class,
        'contact'        => \App\Http\Controllers\web\ContactController::class,
        'real-estate'    => \App\Http\Controllers\web\RealEstateController::class,
        'about'          => \App\Http\Controllers\web\AboutController::class,
        'agendaevent'    => \App\Http\Controllers\web\AgendaEvent\AgendaEventController::class,
        'webinar'        => \App\Http\Controllers\web\Webinar\WebinarController::class,
        'masterclass'    => \App\Http\Controllers\web\Masterclass\MasterclassController::class,
    ];

    /**
     * Get the controller instance for a given page and ensure the required method exists.
     *
     * @param  string  $page
     * @param  string  $method
     * @return object
     */
    protected function getController(string $page, string $method)
    {
        $page = strtolower($page);
        if (!isset($this->controllers[$page])) {
            Log::error("Page not found: {$page}");
            abort(404, "Page not found: {$page}");
        }

        $controllerClass = $this->controllers[$page];
        $controller = app($controllerClass);

        if (!method_exists($controller, $method)) {
            Log::error("Method `{$method}()` missing in " . get_class($controller));
            abort(500, "Method `{$method}()` missing in " . get_class($controller));
        }

        return $controller;
    }

    /**
     * Render a static page dynamically.
     */
    public function renderPage(string $page): Response
    {
        Log::debug("Rendering page: " . strtolower($page));
        $controller = $this->getController($page, 'index');
        return $controller->index();
    }

    // Other dynamic methods (store, show, edit, update, destroy) can follow a similar pattern.
}
