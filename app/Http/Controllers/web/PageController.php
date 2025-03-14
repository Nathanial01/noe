<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class PageController extends Controller
{
    protected array $controllers = [
        'private-equity' => \App\Http\Controllers\web\PrivateEquityController::class,
        'contact'        => \App\Http\Controllers\web\ContactController::class,
        'real-estate'    => \App\Http\Controllers\web\RealEstateController::class,
        'about'          => \App\Http\Controllers\web\AboutController::class,
        'agendaevent'    => \App\Http\Controllers\web\AgendaEvent\AgendaEventController::class,
        'webinar'        => \App\Http\Controllers\web\Webinar\WebinarController::class,
        'masterclass'    => \App\Http\Controllers\web\Masterclass\MasterclassController::class,
    ];

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

    public function renderPage(string $page): Response
    {
        Log::debug("Rendering page: " . strtolower($page));
        $controller = $this->getController($page, 'index');
        return $controller->index();
    }

    public function storePage(string $page, Request $request)
    {
        $controller = $this->getController($page, 'store');

        $storeRequest = \App\Http\Requests\web\StoreContactRequest::createFrom($request);
        $storeRequest->setContainer(app());
        $storeRequest->setRedirector(app('redirect'));
        $storeRequest->validateResolved();

        return app()->call([$controller, 'store'], ['request' => $storeRequest]);
    }
}
