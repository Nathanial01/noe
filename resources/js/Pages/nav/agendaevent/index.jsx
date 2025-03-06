import React, { useState } from 'react';
import { Helmet } from 'react-helmet';
import WebsiteHeader from './WebsiteHeader';
import WebsiteDots from './WebsiteDots';

const CalendarAgendaDemo = () => {
// Sample events data – replace or load as needed
const [events, setEvents] = useState([
{
title: 'Evenement 1',
start_date: '2025-03-06', // use ISO string or Date object
end_date: '2025-03-06',
start_time: '10:00',
end_time: '12:00',
place: 'Locatie 1',
description: 'Beschrijving voor evenement 1. Dit is een voorbeeld van een evenement.',
event_link: 'https://example.com/event1',
map_embed: '', // embed URL if available
status: 'gepland',
},
// ... add more events as needed
]);

const [selectedEventIndex, setSelectedEventIndex] = useState(null);
const [readMeEventIndex, setReadMeEventIndex] = useState(null);
const [viewMode, setViewMode] = useState('details');

// Get the selected event object or null
const selectedEvent =
typeof selectedEventIndex === 'number' && events[selectedEventIndex]
? events[selectedEventIndex]
: null;

// Layout classes change based on whether an event is selected.
const layoutClasses = selectedEvent
? 'max-w-7xl mx-auto flex flex-col md:flex-row gap-6'
: 'max-w-2xl mx-auto';

// Helper to format a date into "dd-mm-yyyy"
const formatDate = (date) => {
const d = new Date(date);
const day = String(d.getDate()).padStart(2, '0');
const month = String(d.getMonth() + 1).padStart(2, '0');
const year = d.getFullYear();
return `${day}-${month}-${year}`;
};

// Return a formatted date string or date range.
const eventDates = (event) => {
const start = formatDate(event.start_date);
const end = formatDate(event.end_date);
return start !== end ? `van ${start} tot ${end}` : `van ${start}`;
};

// Return a CSS class based on event status.
const getStatusClass = (status) => {
switch (status) {
case 'geannuleerd':
return 'text-red-500';
case 'gepland':
return 'text-green-600';
case 'afgelopen':
return 'text-blue-500';
default:
return 'text-gray-500';
}
};

// Handler for selecting an event
const selectEvent = (index, mode = 'details') => {
setSelectedEventIndex(index);
setViewMode(mode);
};

// Handler for opening the "Lees verder" modal
const openReadMeModal = (index) => {
setReadMeEventIndex(index);
};

// Handler for closing the event detail view (mobile)
const closeSelectEvent = () => {
setSelectedEventIndex(null);
};

// Handler for closing the read-me modal
const closeReadMeModal = () => {
setReadMeEventIndex(null);
};

// Extra links when no events are available.
const extraLinks = {
webinar: 'Webinar',
training: 'Training',
coaching: 'Coaching',
masterclass: 'Masterclass',
};

return (
<main className="min-h-screen py-8 px-4 relative">
    <Helmet>
        <title>Kalender Agenda Demo</title>
        <meta
            name="description"
            content="Een Livewire-gebaseerde kalender met dagselectie en evenementdetails."
        />
    </Helmet>

    {/* Header Section */}
    <header className="relative pt-6 pb-6 z-50">
        <WebsiteHeader />
    </header>

    {/* Background Decoration */}
    <WebsiteDots className="-z-10" />

    {/* Intro Section */}
    <section className="max-w-lg mx-auto text-center px-4 mt-24 mb-8 relative z-0">
        <h1 className="text-3xl md:text-4xl font-bold mb-4 text-gray-800">Agenda</h1>
        <p className="text-gray-600 leading-relaxed text-sm">
            Blijf op de hoogte van de nieuwste ontwikkelingen in de huurmarkt! Bij Huurprijscheck.app organiseren we regelmatig masterclasses,
            seminars en in-house trainingen over huurprijsberekeningen, de Wet Betaalbare Huur en het woningwaarderingsstelsel (WWS).
            Bekijk de agenda en meld je aan voor een event bij jou in de buurt of online!
        </p>
    </section>

    {/* Main Content Container */}
    <div className={`${layoutClasses} mb-8 relative z-40`}>
        {/* LEFT COLUMN: Event List or No-Events Message */}
        {events.length ? (
        <section className={selectedEvent ? 'w-full md:w-1/2 space-y-4' : 'w-full space-y-4'}>
        <h1 className="text-3xl md:text-3xl font-bold mb-8 text-gray-800">Evenementen</h1>
        {events.map((event, index) => {
        const isSelected = selectedEventIndex === index;
        const statusClass = getStatusClass(event.status);
        return (
        <article
            key={index}
            className={`bg-gray-200 rounded-lg p-4 flex flex-col md:flex-row items-start md:items-center justify-between cursor-pointer ${isSelected ? 'ring-4 ring-yellow-300' : ''}`}
        onClick={() => selectEvent(index, 'details')}
        >
        <div className="mb-4 md:mb-0 w-full">
            <h2 className="font-bold text-lg text-gray-700">{event.title}</h2>
            <p className="text-sm text-gray-600">
                {eventDates(event)} | van {event.start_time} tot {event.end_time} | {event.place}
            </p>
            <p className="text-xs text-gray-500 mt-2">
                {event.description.length > 60
                ? event.description.substring(0, 60) + '...'
                : event.description}
            </p>
            {event.event_link && (
            <p className="text-xs mt-2">
                <a
                    href={event.event_link}
                    target="_blank"
                    rel="noopener noreferrer"
                    className="text-blue-500 underline"
                >
                    Bekijk evenement
                </a>
            </p>
            )}
            <div className="mt-4 flex items-center justify-between">
                <p className={`text-xs ${statusClass}`}>{event.status}</p>
                <button
                    type="button"
                    onClick={(e) => {
                e.stopPropagation();
                openReadMeModal(index);
                }}
                className="flex items-center text-xs md:text-sm text-gray-600 hover:underline"
                >
                Lees verder...
                <svg className="ml-1" width="15" height="20" viewBox="0 0 0.9 0.9">
                    <path fill="#2196F3" d="M.844.45A.394.394 0 0 1 .45.844.394.394 0 0 1 .056.45a.394.394 0 0 1 .788 0" />
                    <path fill="#fff" d="M.412.412h.075v.206H.412zM.497.309A.047.047 0 0 1 .45.356.047.047 0 0 1 .403.309a.047.047 0 0 1 .094 0" />
                </svg>
                </button>
            </div>
        </div>
        </article>
        );
        })}
        </section>
        ) : (
        <section className="text-center">
            <p className="text-xs text-gray-500 mt-40">
                Er zijn op dit moment geen geplande evenementen. Blijf op de hoogte van aankomende evenementen.
            </p>
            <p className="text-xs text-gray-500 mt-4">Verken onze overige diensten.</p>
            <div className="flex flex-row justify-center gap-x-3.5 mt-16">
                {Object.entries(extraLinks).map(([route, label]) => (
                <div className="text-center" key={route}>
                    <a
                        href={`/website/${route}/index`}
                        className="inline-block bg-yellow-400 hover:bg-yellow-500 transition duration-200 text-gray-800 px-6 py-2 rounded-lg font-semibold focus:outline-none focus:ring-2 focus:ring-yellow-300"
                    >
                        {label}
                    </a>
                </div>
                ))}
            </div>
        </section>
        )}

        {/* RIGHT COLUMN: Event Detail View (if an event is selected) */}
        {selectedEvent && (
        <>
        {/* Mobile Modal Detail (visible only on mobile) */}
        <div
            className="fixed inset-0 flex items-center justify-center z-50 md:hidden px-6"
            role="dialog"
            aria-modal="true"
            aria-labelledby="modal-title"
        >
            {/* Background overlay */}
            <div className="fixed inset-0 bg-black opacity-50" onClick={closeSelectEvent}></div>

            {/* Modal content */}
            <article
                itemScope
                itemType="http://schema.org/Event"
                className="bg-white rounded-lg p-4 mt-12 z-50 w-full max-w-sm sm:max-w-md relative"
            >
                {/* Close button */}
                <button
                    type="button"
                    aria-label="Close"
                    className="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl"
                    onClick={closeSelectEvent}
                >
                    &times;
                </button>

                <header>
                    <h2 id="modal-title" className="font-bold text-xl text-gray-700 mb-2" itemProp="name">
                        {selectedEvent.title}
                    </h2>
                    {selectedEvent.event_link && (
                    <p className="text-sm text-blue-600 mb-2">
                        <a
                            href={selectedEvent.event_link}
                            target="_blank"
                            rel="noopener noreferrer"
                            className="underline"
                        >
                            Bekijk evenement
                        </a>
                    </p>
                    )}
                </header>

                <p className="text-sm text-gray-600 mb-4">
                    van{' '}
                    <time dateTime={new Date(selectedEvent.start_date).toISOString().split('T')[0]} itemProp="startDate">
                    {formatDate(selectedEvent.start_date)}
                    </time>
                    {formatDate(selectedEvent.start_date) !== formatDate(selectedEvent.end_date) && (
                    <>
                    {' '}
                    tot{' '}
                    <time dateTime={new Date(selectedEvent.end_date).toISOString().split('T')[0]} itemProp="endDate">
                    {formatDate(selectedEvent.end_date)}
                    </time>
                </>
                )}
                | van <span itemProp="startTime">{selectedEvent.start_time}</span> tot{' '}
                <span>{selectedEvent.end_time}</span> |{' '}
                <span itemProp="location" itemScope itemType="http://schema.org/Place">
                    <span itemProp="name">{selectedEvent.place}</span>
                  </span>
                </p>

                <div className="text-sm text-gray-700 leading-relaxed mb-6" itemProp="description">
                    {selectedEvent.description}
                </div>

                {selectedEvent.map_embed && (
                <div className="mb-8">
                    <div className="w-full h-64 mb-6">
                        <iframe
                            className="w-full h-full rounded-lg shadow"
                            style={{ border: 0 }}
                        src={selectedEvent.map_embed}
                            allowFullScreen
                            loading="lazy"
                            title="Map"
                        ></iframe>
                    </div>
                </div>
                )}

                {selectedEvent.status === 'afgelopen' ? (
                <p className="text-sm text-blue-600 font-bold mb-4">Het evenement is officieel beëindigd.</p>
                ) : selectedEvent.status === 'geannuleerd' ? (
                <p className="text-sm text-red-600 font-bold mb-4">Dit evenement is afgelast.</p>
                ) : selectedEvent.status === 'gepland' && (
                <>
                <p className="text-sm text-green-600 font-bold mb-4">Doorlopend evenement.</p>
                <div className="text-center">
                    {selectedEvent.event_link ? (
                    <a
                        href={selectedEvent.event_link}
                        target="_blank"
                        rel="noopener noreferrer"
                        className="inline-block bg-yellow-400 hover:bg-yellow-500 transition duration-200 text-gray-800 px-6 py-3 rounded font-semibold focus:outline-none focus:ring-2 focus:ring-yellow-300"
                    >
                        Aanmelden
                    </a>
                    ) : (
                    <p className="text-sm text-gray-600">Geen aanmeldlink beschikbaar.</p>
                    )}
                </div>
            </>
            )}
            </article>
        </div>

        {/* Desktop Detail View (visible on md+ screens) */}
        <section className="hidden md:block w-full md:w-1/2 bg-gray-200 rounded-lg p-6 mt-16 relative z-50">
            <h2 className="font-bold text-xl text-gray-700 mb-2">{selectedEvent.title}</h2>
            {selectedEvent.event_link && (
            <p className="text-sm text-blue-600 mb-2">
                <a
                    href={selectedEvent.event_link}
                    target="_blank"
                    rel="noopener noreferrer"
                    className="underline"
                >
                    Bekijk evenement
                </a>
            </p>
            )}
            <p className="text-sm text-gray-600 mb-4">
                {eventDates(selectedEvent)} | van {selectedEvent.start_time} tot {selectedEvent.end_time} |{' '}
                {selectedEvent.place}
            </p>
            {viewMode !== 'apply' && (
            <>
            <p className="text-sm text-gray-700 leading-relaxed mb-6">{selectedEvent.description}</p>
            {selectedEvent.map_embed ? (
            <div className="mb-8">
                <h3 className="font-semibold text-gray-800 mb-2">Locatie</h3>
                <p className="text-sm text-gray-700 leading-relaxed mb-6">{selectedEvent.location || ''}</p>
                <div className="w-full h-64 mb-6">
                    <iframe
                        className="w-full h-full rounded-lg shadow"
                        style={{ border: 0 }}
                          src={selectedEvent.map_embed}
                        allowFullScreen
                        loading="lazy"
                        title="Map"
                    ></iframe>
                </div>
                {selectedEvent.status === 'afgelopen' ? (
                <p className="text-sm text-blue-600 font-bold mb-4">
                    Deze data zijn al verstreken.
                </p>
                ) : selectedEvent.status === 'geannuleerd' ? (
                <p className="text-sm text-red-600 font-bold mb-4">
                    Dit evenement is geannuleerd.
                </p>
                ) : selectedEvent.status === 'gepland' && (
                <>
                <p className="text-sm text-green-600 font-bold mb-4">Doorlopend evenement.</p>
                <div className="text-center">
                    {selectedEvent.event_link ? (
                    <a
                        href={selectedEvent.event_link}
                        target="_blank"
                        rel="noopener noreferrer"
                        className="inline-block bg-yellow-400 hover:bg-yellow-500 transition duration-200 text-gray-800 px-6 py-3 rounded font-semibold focus:outline-none focus:ring-2 focus:ring-yellow-300"
                    >
                        Aanmelden
                    </a>
                    ) : (
                    <p className="text-sm text-gray-600">Geen aanmeldlink beschikbaar.</p>
                    )}
                </div>
            </>
            )}
    </div>
    ) : (
    <div className="mb-6">
        <h3 className="font-semibold text-gray-800 mb-2">Locatie</h3>
        <p className="text-gray-600">
            Dit evenement is online of er is geen fysieke locatie beschikbaar.
        </p>
    </div>
    )}
</>
)}
</section>
</>
)}

{/* READ-ME MODAL (for “Lees verder” on mobile) */}
{readMeEventIndex !== null && events[readMeEventIndex] && (
<div
    className="fixed inset-0 flex items-center justify-center z-50"
    role="dialog"
    aria-modal="true"
    aria-labelledby="modal-title"
>
    <div className="fixed inset-0 bg-black opacity-50" onClick={closeReadMeModal}></div>
    <article
        itemScope
        itemType="http://schema.org/Event"
        className="bg-white rounded-lg p-6 z-50 max-w-lg w-full relative"
    >
        <button
            type="button"
            aria-label="Close"
            className="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl"
            onClick={closeReadMeModal}
        >
            &times;
        </button>
        <header>
            <h2 id="modal-title" className="font-bold text-xl text-gray-700 mb-2" itemProp="name">
                {events[readMeEventIndex].title}
            </h2>
            {events[readMeEventIndex].event_link && (
            <p className="text-sm text-blue-600 mb-2">
                <a
                    href={events[readMeEventIndex].event_link}
                    target="_blank"
                    rel="noopener noreferrer"
                    className="underline"
                >
                    Bekijk evenement
                </a>
            </p>
            )}
        </header>
        <p className="text-sm text-gray-600 mb-4">
            van{' '}
            <time
                dateTime={new Date(events[readMeEventIndex].start_date).toISOString().split('T')[0]}
            itemProp="startDate"
            >
            {formatDate(events[readMeEventIndex].start_date)}
            </time>
            {formatDate(events[readMeEventIndex].start_date) !== formatDate(events[readMeEventIndex].end_date) && (
            <>
            {' '}
            tot{' '}
            <time
                dateTime={new Date(events[readMeEventIndex].end_date).toISOString().split('T')[0]}
            itemProp="endDate"
            >
            {formatDate(events[readMeEventIndex].end_date)}
            </time>
        </>
        )}
        | van <span itemProp="startTime">{events[readMeEventIndex].start_time}</span> tot{' '}
        <span>{events[readMeEventIndex].end_time}</span> |{' '}
        <span itemProp="location" itemScope itemType="http://schema.org/Place">
                  <span itemProp="name">{events[readMeEventIndex].place}</span>
                </span>
        </p>
        <div className="text-sm text-gray-700 leading-relaxed mb-6" itemProp="description">
            {events[readMeEventIndex].description}
        </div>
        {events[readMeEventIndex].status === 'afgelopen' ? (
        <p className="text-sm text-blue-600 font-bold mb-4">Het evenement is officieel beëindigd.</p>
        ) : events[readMeEventIndex].status === 'geannuleerd' ? (
        <p className="text-sm text-red-600 font-bold mb-4">Dit evenement is afgelast.</p>
        ) : events[readMeEventIndex].status === 'gepland' && (
        <>
        <p className="text-sm text-green-600 font-bold mb-4">Doorlopend evenement.</p>
        <div className="text-center">
            {events[readMeEventIndex].event_link ? (
            <a
                href={events[readMeEventIndex].event_link}
                target="_blank"
                rel="noopener noreferrer"
                className="inline-block bg-yellow-400 hover:bg-yellow-500 transition duration-200 text-gray-800 px-6 py-3 rounded font-semibold focus:outline-none focus:ring-2 focus:ring-yellow-300"
            >
                Aanmelden
            </a>
            ) : (
            <p className="text-sm text-gray-600">Geen aanmeldlink beschikbaar.</p>
            )}
        </div>
    </>
    )}
    </article>
</div>
)}
</div>
{/* End Main Content */}
</main>
);
};

export default CalendarAgendaDemo;
