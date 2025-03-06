<?php
namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\web\ContactController;
use App\Http\Controllers\web\PrivateEquityController;
use App\Http\Controllers\web\RealEstateController;
use App\Http\Controllers\web\AboutController;
use App\Http\Controllers\web\AgendaEvent\AgendaEventController;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Render a static page dynamically.
     */
    public function renderPage(string $page): Response
    {
        return match ($page) {
            'private-equity' => app(PrivateEquityController::class)->index(),
            'contact'         => app(ContactController::class)->index(),
            'real-estate'     => app(RealEstateController::class)->index(),
            'about'           => app(AboutController::class)->index(),
            'agendaEvent'     => app(AgendaEventController::class)->index(),
            default           => abort(404),
        };
    }

    /**
     * Handle form store dynamically.
     */
    public function store(Request $request, string $page)
    {
        return match ($page) {
            'private-equity' => app(PrivateEquityController::class)->store($request),
            'contact'         => app(ContactController::class)->store($request),
            'real-estate'     => app(RealEstateController::class)->store($request),
            'agendaEvent'     => app(AgendaEventController::class)->store($request),
            default           => abort(404),
        };
    }

    /**
     * Show specific item.
     */
    public function show(string $page, int $id): Response
    {
        return match ($page) {
            'private-equity' => app(PrivateEquityController::class)->show($id),
            'contact'         => app(ContactController::class)->show($id),
            'real-estate'     => app(RealEstateController::class)->show($id),
            'agendaEvent'     => app(AgendaEventController::class)->show($id),
            default           => abort(404),
        };
    }

    /**
     * Edit item dynamically.
     */
    public function edit(string $page, int $id): Response
    {
        return match ($page) {
            'private-equity' => app(PrivateEquityController::class)->edit($id),
            'contact'         => app(ContactController::class)->edit($id),
            'real-estate'     => app(RealEstateController::class)->edit($id),
            'AgendaEvent'     => app(AgendaEventController::class)->edit($id),
            default           => abort(404),
        };
    }

    /**
     * Update an item dynamically.
     */
    public function update(Request $request, string $page, int $id)
    {
        return match ($page) {
            'private-equity' => app(PrivateEquityController::class)->update($request, $id),
            'contact'         => app(ContactController::class)->update($request, $id),
            'real-estate'     => app(RealEstateController::class)->update($request, $id),
            'agendaEvent'     => app(AgendaEventController::class)->update($request, $id),
            default           => abort(404),
        };
    }

    /**
     * Delete an item dynamically.
     */
    public function destroy(string $page, int $id)
    {
        return match ($page) {
            'private-equity' => app(PrivateEquityController::class)->destroy($id),
            'contact'         => app(ContactController::class)->destroy($id),
            'real-estate'     => app(RealEstateController::class)->destroy($id),
            'agendaEvent'     => app(AgendaEventController::class)->destroy($id),
            default           => abort(404),
        };
    }
}
