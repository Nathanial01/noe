<?php

namespace App\Http\Controllers\web\AgendaEvent;

use App\Http\Controllers\Controller;
use App\Models\AgendaEvent;
use Illuminate\Database\Eloquent\Collection;
use Inertia\Inertia;
use Inertia\Response;

class AgendaEventController extends Controller
{
    public ?int $selectedEventIndex = null;
    public ?string $viewMode = null;
    public ?int $modalEventIndex = null;
    public ?int $readMeEventIndex = null;

    /**
     * Retrieve all events.
     *
     * @return Collection
     */
    public function getEventsProperty(): Collection
    {
        return AgendaEvent::all();
    }

    /**
     * Get the currently selected event.
     *
     * @return AgendaEvent|null
     */
    public function getSelectedEventProperty(): ?AgendaEvent
    {
        return is_int($this->selectedEventIndex)
            ? AgendaEvent::find($this->selectedEventIndex)
            : null;
    }

    public function selectEvent(int $index, string $mode = 'details'): void
    {
        $this->selectedEventIndex = $index;
        $this->viewMode = $mode;
    }

    /**
     * Clear the selected event (to close the modal, for example).
     */
    public function closeSelectEvent(): void
    {
        $this->selectedEventIndex = null;
    }

    public function openReadMeModel(int $index): void
    {
        $this->readMeEventIndex = $index;
    }

    public function closeReadMeModel(): void
    {
        $this->readMeEventIndex = null;
    }

    public function render(): Response
    {
        return Inertia::render('AgendaEvent/AgendaEventController', [
            'events' => $this->getEventsProperty(),
            'selectedEvent' => $this->getSelectedEventProperty(),
            'viewMode' => $this->viewMode,
            'readMeEventIndex' => $this->readMeEventIndex,
        ]);
    }
}
