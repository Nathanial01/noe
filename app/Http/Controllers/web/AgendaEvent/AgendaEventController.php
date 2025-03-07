<?php

namespace App\Http\Controllers\web\AgendaEvent;

use App\Http\Controllers\Controller;
use App\Models\AgendaEvent;
use Inertia\Inertia;
use Inertia\Response;

class AgendaEventController extends Controller
{
    // UI state properties (if needed to be persisted, consider moving these to client-side).
    public ?int $selectedEventIndex = null;
    public ?string $viewMode = null;
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
        // If using array index as selection, ensure that it matches the collection order.
        return is_int($this->selectedEventIndex)
            ? AgendaEvent::find($this->selectedEventIndex)
            : null;
    }

    public function selectEvent(int $index, string $mode = 'details'): void
    {
        $this->selectedEventIndex = $index;
        $this->viewMode = $mode;
    }

    public function closeSelectEvent(): void
    {
        $this->selectedEventIndex = null;
    }

    public function openReadMeModal(int $index): void
    {
        $this->readMeEventIndex = $index;
    }

    public function closeReadMeModal(): void
    {
        $this->readMeEventIndex = null;
    }

    /**
     * Render the Agenda Event page.
     */
    public function index(): Response
    {
        return Inertia::render('nav/agendaevent/AgendaEvent', [
            'events'            => $this->getEventsProperty(),
            'selectedEvent'     => $this->getSelectedEventProperty(),
            'viewMode'          => $this->viewMode,
            'readMeEventIndex'  => $this->readMeEventIndex,
        ]);
    }
}
