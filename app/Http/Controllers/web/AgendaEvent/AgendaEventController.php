<?php

namespace App\Http\Controllers\web\AgendaEvent;

use App\Http\Controllers\Controller;
use App\Models\AgendaEvent;
use Inertia\Inertia;
use Inertia\Response;

class AgendaEventController extends Controller
{
    // Interactive UI state (consider moving these to the client side if possible)
    public ?int $selectedEventIndex = null;
    public ?string $viewMode = null;
    public ?int $modalEventIndex = null;
    public ?int $readMeEventIndex = null;

    /**
     * Retrieve all events.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getEventsProperty()
    {
        return AgendaEvent::all();
    }

    /**
     * Get the currently selected event.
     *
     * @return \App\Models\AgendaEvent|null
     */
    public function getSelectedEventProperty()
    {
        return is_int($this->selectedEventIndex)
            ? AgendaEvent::find($this->selectedEventIndex)
            : null;
    }

    /**
     * Set the selected event and view mode.
     */
    public function selectEvent(int $index, string $mode = 'details'): void
    {
        $this->selectedEventIndex = $index;
        $this->viewMode = $mode;
    }

    /**
     * Clear the selected event (e.g. to close a modal).
     */
    public function closeSelectEvent(): void
    {
        $this->selectedEventIndex = null;
    }

    /**
     * Open the "Lees verder" modal for an event.
     */
    public function openReadMeModel(int $index): void
    {
        $this->readMeEventIndex = $index;
    }

    /**
     * Close the "Lees verder" modal.
     */
    public function closeReadMeModel(): void
    {
        $this->readMeEventIndex = null;
    }

    /**
     * Render the Agenda Event page.
     *
     * Note: Adjust the view name ('nav/agendaevent/AgendaEvent') to match the location§
     * of your React component.
     *
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('nav/agendaevent/AgendaEvent', [
            'events'         => $this->getEventsProperty(),
            'selectedEvent'  => $this->getSelectedEventProperty(),
            'viewMode'       => $this->viewMode,
            'readMeEventIndex' => $this->readMeEventIndex,
        ]);
    }
}
