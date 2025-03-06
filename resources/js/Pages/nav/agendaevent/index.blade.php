{{-- Push page title and description --}}
@push('title')
    Kalender Agenda Demo
@endpush

@push('description')
    Een Livewire-gebaseerde kalender met dagselectie en evenementdetails.
@endpush

<main class="min-h-screen py-8 px-4 relative">
    @php
        // Determine the selected event (if any)
        $selectedEvent = is_int($this->selectedEventIndex) && isset($this->events[$this->selectedEventIndex])
            ? $this->events[$this->selectedEventIndex]
            : null;
        // Set layout classes based on whether an event is selected.
        $layoutClasses = $selectedEvent
            ? 'max-w-7xl mx-auto flex flex-col md:flex-row gap-6'
            : 'max-w-2xl mx-auto';
        $viewMode = $this->viewMode;

        /**
         * Format a date or date range.
         *
         * @param  array  $event
         * @return string
         */
        function eventDates($event) {
            $start = ($event['start_date'] instanceof \Carbon\Carbon)
                ? $event['start_date']->format('d-m-Y')
                : \Carbon\Carbon::parse($event['start_date'])->format('d-m-Y');
            $end = ($event['end_date'] instanceof \Carbon\Carbon)
                ? $event['end_date']->format('d-m-Y')
                : \Carbon\Carbon::parse($event['end_date'])->format('d-m-Y');
            return $start !== $end ? "van {$start} tot {$end}" : "van {$start}";
        }
    @endphp

    {{-- Header Section --}}
    <header class="relative pt-6 pb-6 z-50">
        <x-website-header />
    </header>

    {{-- Background Decoration --}}
    <x-website.dots class="-z-10" />

    {{-- Intro Section --}}
    <section class="max-w-lg mx-auto text-center px-4 mt-24 mb-8 relative z-0">
        <h1 class="text-3xl md:text-4xl font-bold mb-4 text-gray-800">Agenda</h1>
        <p class="text-gray-600 leading-relaxed text-sm">
            Blijf op de hoogte van de nieuwste ontwikkelingen in de huurmarkt!
            Bij Huurprijscheck.app organiseren we regelmatig masterclasses, seminars en in-house trainingen over huurprijsberekeningen, de Wet Betaalbare Huur en het woningwaarderingsstelsel (WWS).
            Bekijk de agenda en meld je aan voor een event bij jou in de buurt of online!
        </p>
    </section>

    {{-- Main Content Container --}}
    <div class="{{ $layoutClasses }} mb-8 relative z-40">
        {{-- LEFT COLUMN: Event List or No-Events Message --}}
        @if ($this->events->count())
            <section class="{{ $selectedEvent ? 'w-full md:w-1/2' : 'w-full' }} space-y-4">
                <h1 class="text-3xl md:text-3xl font-bold mb-8 text-gray-800">Evenementen</h1>

                @foreach ($this->events as $index => $event)
                    @php
                        $isSelected = ($this->selectedEventIndex === $index);
                        $statusClass = match ($event['status']) {
                            'geannuleerd' => 'text-red-500',
                            'gepland'     => 'text-green-600',
                            'afgelopen'   => 'text-blue-500',
                            default       => 'text-gray-500',
                        };
                    @endphp

                    {{-- Event Block --}}
                    <article
                        wire:key="event-{{ $index }}"
                        class="bg-gray-200 rounded-lg p-4 flex flex-col md:flex-row items-start md:items-center justify-between cursor-pointer {{ $isSelected ? 'ring-4 ring-yellow-300' : '' }}"
                        wire:click="selectEvent({{ $index }}, 'details'); openModal({{ $index }})"
                    >
                        <div class="mb-4 md:mb-0 w-full">
                            <h2 class="font-bold text-lg text-gray-700">{{ $event['title'] }}</h2>
                            <p class="text-sm text-gray-600">
                                {{ eventDates($event) }} |
                                van {{ $event['start_time'] }} tot {{ $event['end_time'] }}
                                | {{ $event['place'] }}
                            </p>
                            <p class="text-xs text-gray-500 mt-2">
                                {{ \Illuminate\Support\Str::limit($event['description'], 60) }}
                            </p>
                            {{-- Dynamic Event Link (if available) --}}
                            @if (!empty($event['event_link']))
                                <p class="text-xs mt-2">
                                    <a href="{{ $event['event_link'] }}" target="_blank" class="text-blue-500 underline">
                                        Bekijk evenement
                                    </a>
                                </p>
                            @endif
                            <div class="mt-4 flex items-center justify-between">
                                <p class="text-xs {{ $statusClass }}">{{ $event['status'] }}</p>
                                <button
                                    type="button"
                                    wire:click.stop="openReadMeModel({{ $index }})"
                                    class="flex items-center text-xs md:text-sm text-gray-600 hover:underline"
                                >
                                    Lees verder...
                                    <svg class="ml-1" width="15" height="20" viewBox="0 0 0.9 0.9">
                                        <path fill="#2196F3" d="M.844.45A.394.394 0 0 1 .45.844.394.394 0 0 1 .056.45a.394.394 0 0 1 .788 0"/>
                                        <path fill="#fff" d="M.412.412h.075v.206H.412zM.497.309A.047.047 0 0 1 .45.356.047.047 0 0 1 .403.309a.047.047 0 0 1 .094 0"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </article>
                @endforeach
            </section>
        @else
            {{-- No events message and extra links --}}
            <section class="text-center">
                <p class="text-xs text-gray-500 mt-40">
                    Er zijn op dit moment geen geplande evenementen. Blijf op de hoogte van aankomende evenementen.
                </p>
                <p class="text-xs text-gray-500 mt-4">
                    Verken onze overige diensten.
                </p>
                <div class="flex flex-row justify-center gap-x-3.5 mt-16">
                    @foreach (['webinar' => 'Webinar', 'training' => 'Training', 'coaching' => 'Coaching', 'masterclass' => 'Masterclass'] as $route => $label)
                        <div class="text-center">
                            <a href="{{ route("website.{$route}.index") }}"
                               class="inline-block bg-yellow-400 hover:bg-yellow-500 transition duration-200 text-gray-800 px-6 py-2 rounded-lg font-semibold focus:outline-none focus:ring-2 focus:ring-yellow-300">
                                {{ $label }}
                            </a>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- RIGHT COLUMN: Event Detail View (if an event is selected) --}}
        @if ($selectedEvent)
            {{-- Mobile Modal Detail (visible only on mobile) --}}

            <div class="fixed inset-0 flex items-center justify-center z-50 md:hidden px-6" role="dialog" aria-modal="true" aria-labelledby="modal-title">
                <!-- Background overlay -->
                <div class="fixed inset-0 bg-black opacity-50" wire:click="closeSelectEvent"></div>

                <!-- Modal content -->
                <article itemscope itemtype="http://schema.org/Event" class="bg-white rounded-lg p-4 mt-12 z-50 w-full max-w-sm sm:max-w-md relative">
                    <!-- Close button -->
                    <button type="button" aria-label="Close" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl" wire:click="closeSelectEvent">
                        &times;
                    </button>

                    <header>
                        <h2 id="modal-title" class="font-bold text-xl text-gray-700 mb-2" itemprop="name">
                            {{ $selectedEvent['title'] }}
                        </h2>
                        {{-- Dynamic Event Link in Mobile Detail --}}
                        @if (!empty($selectedEvent['event_link']))
                            <p class="text-sm text-blue-600 mb-2">
                                <a href="{{ $selectedEvent['event_link'] }}" target="_blank" class="underline">
                                    Bekijk evenement
                                </a>
                            </p>
                        @endif
                    </header>

                    <p class="text-sm text-gray-600 mb-4">
                        van
                        <time datetime="{{ $selectedEvent['start_date'] instanceof \Carbon\Carbon ? $selectedEvent['start_date']->toDateString() : \Carbon\Carbon::parse($selectedEvent['start_date'])->toDateString() }}" itemprop="startDate">
                            {{ $selectedEvent['start_date'] instanceof \Carbon\Carbon ? $selectedEvent['start_date']->format('d-m-Y') : \Carbon\Carbon::parse($selectedEvent['start_date'])->format('d-m-Y') }}
                        </time>
                        @if (
                            ($selectedEvent['start_date'] instanceof \Carbon\Carbon
                                ? $selectedEvent['start_date']->toDateString()
                                : \Carbon\Carbon::parse($selectedEvent['start_date'])->toDateString())
                            !==
                            ($selectedEvent['end_date'] instanceof \Carbon\Carbon
                                ? $selectedEvent['end_date']->toDateString()
                                : \Carbon\Carbon::parse($selectedEvent['end_date'])->toDateString())
                        )
                            tot
                            <time datetime="{{ $selectedEvent['end_date'] instanceof \Carbon\Carbon ? $selectedEvent['end_date']->toDateString() : \Carbon\Carbon::parse($selectedEvent['end_date'])->toDateString() }}" itemprop="endDate">
                                {{ $selectedEvent['end_date'] instanceof \Carbon\Carbon ? $selectedEvent['end_date']->format('d-m-Y') : \Carbon\Carbon::parse($selectedEvent['end_date'])->format('d-m-Y') }}
                            </time>
                        @endif
                        | van <span itemprop="startTime">{{ $selectedEvent['start_time'] }}</span> tot <span>{{ $selectedEvent['end_time'] }}</span>
                        | <span itemprop="location" itemscope itemtype="http://schema.org/Place">
          <span itemprop="name">{{ $selectedEvent['place'] }}</span>
        </span>
                    </p>

                    <div class="text-sm text-gray-700 leading-relaxed mb-6" itemprop="description">
                        {{ $selectedEvent['description'] }}
                    </div>

                    @if (!empty($selectedEvent['map_embed']))
                        <div class="mb-8">
                            <div class="w-full h-64 mb-6">
                                <iframe class="w-full h-full rounded-lg shadow"
                                        style="border:0"
                                        src="{{ $selectedEvent['map_embed'] }}"
                                        allowfullscreen
                                        loading="lazy"></iframe>
                            </div>
                        </div>
                    @endif

                    @if ($selectedEvent['status'] === 'afgelopen')
                        <p class="text-sm text-blue-600 font-bold mb-4">
                            Het evenement is officieel beëindigd.
                        </p>
                    @elseif ($selectedEvent['status'] === 'geannuleerd')
                        <p class="text-sm text-red-600 font-bold mb-4">
                            Dit evenement is afgelast.
                        </p>
                    @elseif ($selectedEvent['status'] === 'gepland')
                        <p class="text-sm text-green-600 font-bold mb-4">
                            Doorlopend evenement.
                        </p>
                        <div class="text-center">
                            @if (!empty($selectedEvent['event_link']))
                                <a href="{{ $selectedEvent['event_link'] }}" target="_blank"
                                   class="inline-block bg-yellow-400 hover:bg-yellow-500 transition duration-200 text-gray-800 px-6 py-3 rounded font-semibold focus:outline-none focus:ring-2 focus:ring-yellow-300">
                                    Aanmelden
                                </a>
                            @else
                                <p class="text-sm text-gray-600">Geen aanmeldlink beschikbaar.</p>
                            @endif
                        </div>
                    @endif
                </article>
            </div>

            {{-- Desktop Detail View (visible on md+ screens) --}}
            <section class="hidden md:block w-full md:w-1/2 bg-gray-200 rounded-lg p-6 mt-16 relative z-50">
                <h2 class="font-bold text-xl text-gray-700 mb-2">{{ $selectedEvent['title'] }}</h2>
                {{-- Dynamic Event Link in Desktop Detail --}}
                @if (!empty($selectedEvent['event_link']))
                    <p class="text-sm text-blue-600 mb-2">
                        <a href="{{ $selectedEvent['event_link'] }}" target="_blank" class="underline">
                            Bekijk evenement
                        </a>
                    </p>
                @endif
                <p class="text-sm text-gray-600 mb-4">
                    {{ eventDates($selectedEvent) }} | van {{ $selectedEvent['start_time'] }} tot {{ $selectedEvent['end_time'] }}
                    | {{ $selectedEvent['place'] }}
                </p>
                @if ($viewMode !== 'apply')
                    <p class="text-sm text-gray-700 leading-relaxed mb-6">
                        {{ $selectedEvent['description'] }}
                    </p>
                    @if (!empty($selectedEvent['map_embed']))
                        <div class="mb-8">
                            <h3 class="font-semibold text-gray-800 mb-2">Locatie</h3>
                            <p class="text-sm text-gray-700 leading-relaxed mb-6">
                                {{ $selectedEvent['location'] }}
                            </p>
                            <div class="w-full h-64 mb-6">
                                <iframe class="w-full h-full rounded-lg shadow"
                                        style="border:0"
                                        src="{{ $selectedEvent['map_embed'] }}"
                                        allowfullscreen
                                        loading="lazy"></iframe>
                            </div>
                            @if ($selectedEvent['status'] === 'afgelopen')
                                <p class="text-sm text-blue-600 font-bold mb-4">
                                    Deze data zijn al verstreken.
                                </p>
                            @elseif ($selectedEvent['status'] === 'geannuleerd')
                                <p class="text-sm text-red-600 font-bold mb-4">
                                    Dit evenement is geannuleerd.
                                </p>
                            @elseif ($selectedEvent['status'] === 'gepland')
                                <p class="text-sm text-green-600 font-bold mb-4">
                                    Doorlopend evenement.
                                </p>
                                <div class="text-center">
                                    @if (!empty($selectedEvent['event_link']))
                                        <a href="{{ $selectedEvent['event_link'] }}" target="_blank"
                                           class="inline-block bg-yellow-400 hover:bg-yellow-500 transition duration-200 text-gray-800 px-6 py-3 rounded font-semibold focus:outline-none focus:ring-2 focus:ring-yellow-300">
                                            Aanmelden
                                        </a>
                                    @else
                                        <p class="text-sm text-gray-600">Geen aanmeldlink beschikbaar.</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="mb-6">
                            <h3 class="font-semibold text-gray-800 mb-2">Locatie</h3>
                            <p class="text-gray-600">
                                Dit evenement is online of er is geen fysieke locatie beschikbaar.
                            </p>
                        </div>
                    @endif
                @endif
            </section>
        @endif

        {{-- READ-ME MODAL (for “Lees verder” on mobile) --}}
        @if (!is_null($readMeEventIndex))
            @php $modalEvent = $this->events[$readMeEventIndex] ?? null; @endphp
            @if ($modalEvent)
                <div class="fixed inset-0 flex items-center justify-center z-50" role="dialog" aria-modal="true" aria-labelledby="modal-title">
                    <div class="fixed inset-0 bg-black opacity-50" wire:click="closeReadMeModel"></div>
                    <article itemscope itemtype="http://schema.org/Event" class="bg-white rounded-lg p-6 z-50 max-w-lg w-full relative">
                        <button type="button" aria-label="Close" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl" wire:click="closeReadMeModel">
                            &times;
                        </button>
                        <header>
                            <h2 id="modal-title" class="font-bold text-xl text-gray-700 mb-2" itemprop="name">
                                {{ $modalEvent['title'] }}
                            </h2>
                            {{-- Dynamic Event Link in Read-Me Modal --}}
                            @if (!empty($modalEvent['event_link']))
                                <p class="text-sm text-blue-600 mb-2">
                                    <a href="{{ $modalEvent['event_link'] }}" target="_blank" class="underline">
                                        Bekijk evenement
                                    </a>
                                </p>
                            @endif
                        </header>
                        <p class="text-sm text-gray-600 mb-4">
                            van <time datetime="{{ $modalEvent['start_date'] instanceof \Carbon\Carbon ? $modalEvent['start_date']->toDateString() : \Carbon\Carbon::parse($modalEvent['start_date'])->toDateString() }}" itemprop="startDate">
                                {{ $modalEvent['start_date'] instanceof \Carbon\Carbon ? $modalEvent['start_date']->format('d-m-Y') : \Carbon\Carbon::parse($modalEvent['start_date'])->format('d-m-Y') }}
                            </time>
                            @if (
                                ($modalEvent['start_date'] instanceof \Carbon\Carbon
                                    ? $modalEvent['start_date']->toDateString()
                                    : \Carbon\Carbon::parse($modalEvent['start_date'])->toDateString())
                                !==
                                ($modalEvent['end_date'] instanceof \Carbon\Carbon
                                    ? $modalEvent['end_date']->toDateString()
                                    : \Carbon\Carbon::parse($modalEvent['end_date'])->toDateString())
                            )
                                tot <time datetime="{{ $modalEvent['end_date'] instanceof \Carbon\Carbon ? $modalEvent['end_date']->toDateString() : \Carbon\Carbon::parse($modalEvent['end_date'])->toDateString() }}" itemprop="endDate">
                                    {{ $modalEvent['end_date'] instanceof \Carbon\Carbon ? $modalEvent['end_date']->format('d-m-Y') : \Carbon\Carbon::parse($modalEvent['end_date'])->format('d-m-Y') }}
                                </time>
                            @endif
                            | van <span itemprop="startTime">{{ $modalEvent['start_time'] }}</span> tot <span>{{ $modalEvent['end_time'] }}</span>
                            | <span itemprop="location" itemscope itemtype="http://schema.org/Place">
                                  <span itemprop="name">{{ $modalEvent['place'] }}</span>
                              </span>
                        </p>
                        <div class="text-sm text-gray-700 leading-relaxed mb-6" itemprop="description">
                            {{ $modalEvent['description'] }}
                        </div>
                        @if ($modalEvent['status'] === 'afgelopen')
                            <p class="text-sm text-blue-600 font-bold mb-4">
                                Het evenement is officieel beëindigd.
                            </p>
                        @elseif ($modalEvent['status'] === 'geannuleerd')
                            <p class="text-sm text-red-600 font-bold mb-4">
                                Dit evenement is afgelast.
                            </p>
                        @elseif ($modalEvent['status'] === 'gepland')
                            <p class="text-sm text-green-600 font-bold mb-4">
                                Doorlopend evenement.
                            </p>
                            <div class="text-center">
                                @if (!empty($modalEvent['event_link']))
                                    <a href="{{ $modalEvent['event_link'] }}" target="_blank"
                                       class="inline-block bg-yellow-400 hover:bg-yellow-500 transition duration-200 text-gray-800 px-6 py-3 rounded font-semibold focus:outline-none focus:ring-2 focus:ring-yellow-300">
                                        Aanmelden
                                    </a>
                                @else
                                    <p class="text-sm text-gray-600">Geen aanmeldlink beschikbaar.</p>
                                @endif
                            </div>
                        @endif
                    </article>
                </div>
            @endif
        @endif
    </div>
    {{-- End Main Content --}}
</main>
