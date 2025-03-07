import React, { useState, useEffect, useRef } from 'react';
import { Helmet } from 'react-helmet';
import { gsap } from 'gsap';
import NavBar from "@/Layouts/NavBar.jsx";
import { usePage } from "@inertiajs/react";

export default function AgendaEvent() {
    // Retrieve events passed from the server via Inertia.
    const { events: serverEvents } = usePage().props;
    const [events] = useState(serverEvents || []);
    const [selectedEventIndex, setSelectedEventIndex] = useState(null);
    const [readMeEventIndex, setReadMeEventIndex] = useState(null);
    const [viewMode, setViewMode] = useState('details');

    const selectedEvent =
        typeof selectedEventIndex === 'number' && events[selectedEventIndex]
            ? events[selectedEventIndex]
            : null;

    // Set layout classes based on whether an event is selected.
    const layoutClasses = selectedEvent
        ? 'max-w-7xl mx-auto flex flex-col md:flex-row gap-6'
        : 'max-w-2xl mx-auto';

    // Helper to format a date string.
    const formatDate = (dateStr) => {
        const d = new Date(dateStr);
        const day = String(d.getDate()).padStart(2, '0');
        const month = String(d.getMonth() + 1).padStart(2, '0');
        const year = d.getFullYear();
        return `${day}-${month}-${year}`;
    };

    // Format a date or date range.
    const eventDates = (event) => {
        const start = formatDate(event.start_date);
        const end = formatDate(event.end_date);
        return start !== end ? `van ${start} tot ${end}` : `van ${start}`;
    };

    // Even though getStatusClass originally returns different colors,
    // we now force all text to white.
    const getStatusClass = () => 'text-white';

    const selectEvent = (index, mode = 'details') => {
        setSelectedEventIndex(index);
        setViewMode(mode);
    };

    const closeSelectEvent = () => setSelectedEventIndex(null);
    const openReadMeModal = (index) => setReadMeEventIndex(index);
    const closeReadMeModal = () => setReadMeEventIndex(null);

    // Extra links for fallback service cards.
    const extraLinks = {
        webinar: {
            title: 'Webinar',
            subtitle: 'Live Session',
            link: '/website'
        },
        agenda: {
            title: 'Agenda',
            subtitle: 'Upcoming Events',
            link: "/agendaEvent",
        },
        masterclass: {
            title: 'Masterclass',
            subtitle: 'In-Depth Class',
            link: 'masterclass'
        }
    };

    // Reference for fallback cards container.
    const fallbackRef = useRef(null);
    useEffect(() => {
        if (!events.length && fallbackRef.current) {
            gsap.from(fallbackRef.current.children, {
                opacity: 0,
                y: 50,
                stagger: 0.2,
                duration: 1,
            });
        }
    }, [events]);

    // Reusable ServiceCard component.
    const ServiceCard = ({ title, subtitle, link }) => (
        <a href={link} className="text-white cursor-pointer mt-44">
            <div className="group flex flex-col gap-4 w-32 h-40 backdrop-blur-3xl rounded-2xl p-4 shadow-xl border-2 border-transparent transition-all duration-300 ease-in-out hover:border-indigo-500 hover:shadow-indigo-500/20">
                <div className="relative">
                    <div className="w-12 h-12 mx-auto bg-indigo-500/20 rounded-lg border-2 border-indigo-500/40 group-hover:border-amber-400 group-hover:bg-indigo-500/30 transition-all duration-300">
                        <div className="flex flex-col gap-1 p-2">
                            <div className="h-1 w-8 bg-indigo-400/40 rounded-full"></div>
                            <div className="h-1 w-6 bg-indigo-400/40 rounded-full"></div>
                            <div className="h-1 w-7 bg-indigo-400/40 rounded-full"></div>
                        </div>
                    </div>
                </div>
                <div className="text-center">
                    <p className="font-medium text-sm group-hover:text-white transition-colors duration-300">
                        {title}
                    </p>
                    <p className="text-xs mt-1 opacity-60 group-hover:opacity-100 transition-opacity duration-300">
                        {subtitle}
                    </p>
                </div>
                <div className="h-1 w-0 bg-indigo-500 rounded-full mx-auto group-hover:w-full transition-all duration-300"></div>
            </div>
        </a>
    );

    return (
        <NavBar>
            <main className="min-h-screen py-8 px-4 relative">
                <Helmet>
                    <title>Kalender Agenda Demo</title>
                    <meta name="description" content="Een Livewire-gebaseerde kalender met dagselectie en evenementdetails." />
                </Helmet>

                {/* Intro Section */}
                <section className="max-w-lg mx-auto text-center px-4 mt-24 mb-8 relative z-0">
                    <h1 className="text-3xl md:text-4xl font-bold mb-4 text-white">Agenda</h1>
                    <p className="text-white leading-relaxed">
                        Blijf op de hoogte van de nieuwste evenementen in de agenda.
                        Hier vind je een overzicht van geplande bijeenkomsten, workshops en netwerkevenementen.
                        Ontdek interessante activiteiten en meld je eenvoudig aan voor een event dat bij jou past!
                    </p>
                </section>

                {/* Main Content Container */}
                <div className={`${layoutClasses} mb-8 relative z-40`}>
                    {events.length > 0 ? (
                        <section className={selectedEvent ? 'w-full md:w-1/2 space-y-4' : 'w-full space-y-4'}>
                            <h1 className="text-3xl md:text-3xl font-bold mb-8 text-white">Evenementen</h1>
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
                                            <h2 className="font-bold text-lg text-white">{event.title}</h2>
                                            <p className="text-sm text-white">
                                                {eventDates(event)} | van {event.start_time} tot {event.end_time} | {event.place}
                                            </p>
                                            <p className="text-xs text-white mt-2">
                                                {event.description.length > 60 ? event.description.substring(0, 60) + '...' : event.description}
                                            </p>
                                            {event.event_link && (
                                                <p className="text-xs mt-2">
                                                    <a href={event.event_link} target="_blank" rel="noopener noreferrer" className="underline text-white">
                                                        Bekijk evenement
                                                    </a>
                                                </p>
                                            )}
                                            <div className="mt-4 flex items-center justify-between">
                                                <p className={`text-xs ${statusClass}`}>{event.status}</p>
                                                <button
                                                    type="button"
                                                    onClick={(e) => { e.stopPropagation(); openReadMeModal(index); }}
                                                    className="flex items-center text-xs md:text-sm text-white hover:underline"
                                                >
                                                    Lees verder...
                                                    <svg className="ml-1" width="15" height="20" viewBox="0 0 0.9 0.9">
                                                        <path fill="#ffffff" d="M.844.45A.394.394 0 0 1 .45.844.394.394 0 0 1 .056.45a.394.394 0 0 1 .788 0" />
                                                        <path fill="#ffffff" d="M.412.412h.075v.206H.412zM.497.309A.047.047 0 0 1 .45.356.047.047 0 0 1 .403.309a.047.047 0 0 1 .094 0" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </article>
                                );
                            })}
                        </section>
                    ) : (
                        // Fallback Section: Display three clickable service cards.
                        <div ref={fallbackRef} className="flex flex-wrap gap-6 justify-center items-center">
                            <ServiceCard title={extraLinks.webinar.title} subtitle={extraLinks.webinar.subtitle} link={extraLinks.webinar.link} />
                            <ServiceCard title={extraLinks.agenda.title} subtitle={extraLinks.agenda.subtitle} link={extraLinks.agenda.link} />
                            <ServiceCard title={extraLinks.masterclass.title} subtitle={extraLinks.masterclass.subtitle} link={extraLinks.masterclass.link} />
                        </div>
                    )}

                    {/* RIGHT COLUMN: Event Detail View */}
                    {selectedEvent && (
                        <>
                            {/* Mobile Modal Detail */}
                            <div className="fixed inset-0 flex items-center justify-center z-50 md:hidden px-6" role="dialog" aria-modal="true" aria-labelledby="modal-title">
                                <div className="fixed inset-0 bg-black opacity-50" onClick={closeSelectEvent}></div>
                                <article itemScope itemType="http://schema.org/Event" className="bg-white rounded-lg p-4 mt-12 z-50 w-full max-w-sm sm:max-w-md relative">
                                    <button type="button" aria-label="Close" className="absolute top-2 right-2 text-white hover:text-gray-300 text-2xl" onClick={closeSelectEvent}>
                                        &times;
                                    </button>
                                    <header>
                                        <h2 id="modal-title" className="font-bold text-xl text-white mb-2" itemProp="name">
                                            {selectedEvent.title}
                                        </h2>
                                        {selectedEvent.event_link && (
                                            <p className="text-sm text-white mb-2">
                                                <a href={selectedEvent.event_link} target="_blank" rel="noopener noreferrer" className="underline text-white">
                                                    Bekijk evenement
                                                </a>
                                            </p>
                                        )}
                                    </header>
                                    <p className="text-sm text-white mb-4">
                                        van{' '}
                                        <time dateTime={new Date(selectedEvent.start_date).toISOString().split('T')[0]} itemProp="startDate">
                                            {formatDate(selectedEvent.start_date)}
                                        </time>
                                        {formatDate(selectedEvent.start_date) !== formatDate(selectedEvent.end_date) && (
                                            <>
                                                {' '}tot{' '}
                                                <time dateTime={new Date(selectedEvent.end_date).toISOString().split('T')[0]} itemProp="endDate">
                                                    {formatDate(selectedEvent.end_date)}
                                                </time>
                                            </>
                                        )}
                                        | van <span itemProp="startTime">{selectedEvent.start_time}</span> tot <span>{selectedEvent.end_time}</span> |{' '}
                                        <span itemProp="location" itemScope itemType="http://schema.org/Place">
                                            <span itemProp="name">{selectedEvent.place}</span>
                                        </span>
                                    </p>
                                    <div className="text-sm text-white leading-relaxed mb-6" itemProp="description">
                                        {selectedEvent.description}
                                    </div>
                                    {selectedEvent.map_embed && (
                                        <div className="mb-8">
                                            <div className="w-full h-64 mb-6">
                                                <iframe className="w-full h-full rounded-lg shadow" style={{ border: 0 }} src={selectedEvent.map_embed} allowFullScreen loading="lazy" title="Map"></iframe>
                                            </div>
                                        </div>
                                    )}
                                    {selectedEvent.status === 'afgelopen' ? (
                                        <p className="text-sm text-white font-bold mb-4">Het evenement is officieel beëindigd.</p>
                                    ) : selectedEvent.status === 'geannuleerd' ? (
                                        <p className="text-sm text-white font-bold mb-4">Dit evenement is afgelast.</p>
                                    ) : selectedEvent.status === 'gepland' && (
                                        <>
                                            <p className="text-sm text-white font-bold mb-4">Doorlopend evenement.</p>
                                            <div className="text-center">
                                                {selectedEvent.event_link ? (
                                                    <a href={selectedEvent.event_link} target="_blank" rel="noopener noreferrer" className="inline-block bg-yellow-400 hover:bg-yellow-500 transition duration-200 text-white px-6 py-3 rounded font-semibold focus:outline-none focus:ring-2 focus:ring-yellow-300">
                                                        Aanmelden
                                                    </a>
                                                ) : (
                                                    <p className="text-sm text-white">Geen aanmeldlink beschikbaar.</p>
                                                )}
                                            </div>
                                        </>
                                    )}
                                </article>
                            </div>

                            {/* Desktop Detail View */}
                            <section className="hidden md:block w-full md:w-1/2 bg-gray-200 rounded-lg p-6 mt-16 relative z-50">
                                <h2 className="font-bold text-xl text-white mb-2">{selectedEvent.title}</h2>
                                {selectedEvent.event_link && (
                                    <p className="text-sm text-white mb-2">
                                        <a href={selectedEvent.event_link} target="_blank" rel="noopener noreferrer" className="underline text-white">
                                            Bekijk evenement
                                        </a>
                                    </p>
                                )}
                                <p className="text-sm text-white mb-4">
                                    {eventDates(selectedEvent)} | van {selectedEvent.start_time} tot {selectedEvent.end_time} | {selectedEvent.place}
                                </p>
                                {viewMode !== 'apply' && (
                                    <>
                                        <p className="text-sm text-white leading-relaxed mb-6">{selectedEvent.description}</p>
                                        {selectedEvent.map_embed ? (
                                            <div className="mb-8">
                                                <h3 className="font-semibold text-white mb-2">Locatie</h3>
                                                <p className="text-sm text-white leading-relaxed mb-6">
                                                    {selectedEvent.location || ''}
                                                </p>
                                                <div className="w-full h-64 mb-6">
                                                    <iframe className="w-full h-full rounded-lg shadow" style={{ border: 0 }} src={selectedEvent.map_embed} allowFullScreen loading="lazy" title="Map"></iframe>
                                                </div>
                                                {selectedEvent.status === 'afgelopen' ? (
                                                    <p className="text-sm text-white font-bold mb-4">Deze data zijn al verstreken.</p>
                                                ) : selectedEvent.status === 'geannuleerd' ? (
                                                    <p className="text-sm text-white font-bold mb-4">Dit evenement is geannuleerd.</p>
                                                ) : selectedEvent.status === 'gepland' && (
                                                    <>
                                                        <p className="text-sm text-white font-bold mb-4">Doorlopend evenement.</p>
                                                        <div className="text-center">
                                                            {selectedEvent.event_link ? (
                                                                <a href={selectedEvent.event_link} target="_blank" rel="noopener noreferrer" className="inline-block bg-yellow-400 hover:bg-yellow-500 transition duration-200 text-white px-6 py-3 rounded font-semibold focus:outline-none focus:ring-2 focus:ring-yellow-300">
                                                                    Aanmelden
                                                                </a>
                                                            ) : (
                                                                <p className="text-sm text-white">Geen aanmeldlink beschikbaar.</p>
                                                            )}
                                                        </div>
                                                    </>
                                                )}
                                            </div>
                                        ) : (
                                            <div className="mb-6">
                                                <h3 className="font-semibold text-white mb-2">Locatie</h3>
                                                <p className="text-white">
                                                    Dit evenement is online of er is geen fysieke locatie beschikbaar.
                                                </p>
                                            </div>
                                        )}
                                    </>
                                )}
                            </section>
                        </>
                    )}

                    {readMeEventIndex !== null && events[readMeEventIndex] && (
                        <div className="fixed inset-0 flex items-center justify-center z-50" role="dialog" aria-modal="true" aria-labelledby="modal-title">
                            <div className="fixed inset-0 bg-black opacity-50" onClick={closeReadMeModal}></div>
                            <article itemScope itemType="http://schema.org/Event" className="bg-white rounded-lg p-6 z-50 max-w-lg w-full relative">
                                <button type="button" aria-label="Close" className="absolute top-2 right-2 text-white hover:text-gray-300 text-2xl" onClick={closeReadMeModal}>
                                    &times;
                                </button>
                                <header>
                                    <h2 id="modal-title" className="font-bold text-xl text-white mb-2" itemProp="name">
                                        {events[readMeEventIndex].title}
                                    </h2>
                                    {events[readMeEventIndex].event_link && (
                                        <p className="text-sm text-white mb-2">
                                            <a href={events[readMeEventIndex].event_link} target="_blank" rel="noopener noreferrer" className="underline text-white">
                                                Bekijk evenement
                                            </a>
                                        </p>
                                    )}
                                </header>
                                <p className="text-sm text-white mb-4">
                                    van{' '}
                                    <time dateTime={new Date(events[readMeEventIndex].start_date).toISOString().split('T')[0]} itemProp="startDate">
                                        {formatDate(events[readMeEventIndex].start_date)}
                                    </time>
                                    {formatDate(events[readMeEventIndex].start_date) !== formatDate(events[readMeEventIndex].end_date) && (
                                        <>
                                            {' '}tot{' '}
                                            <time dateTime={new Date(events[readMeEventIndex].end_date).toISOString().split('T')[0]} itemProp="endDate">
                                                {formatDate(events[readMeEventIndex].end_date)}
                                            </time>
                                        </>
                                    )}
                                    | van <span itemProp="startTime">{events[readMeEventIndex].start_time}</span> tot <span>{events[readMeEventIndex].end_time}</span> |{' '}
                                    <span itemProp="location" itemScope itemType="http://schema.org/Place">
                                        <span itemProp="name">{events[readMeEventIndex].place}</span>
                                    </span>
                                </p>
                                <div className="text-sm text-white leading-relaxed mb-6" itemProp="description">
                                    {events[readMeEventIndex].description}
                                </div>
                                {events[readMeEventIndex].status === 'afgelopen' ? (
                                    <p className="text-sm text-white font-bold mb-4">Het evenement is officieel beëindigd.</p>
                                ) : events[readMeEventIndex].status === 'geannuleerd' ? (
                                    <p className="text-sm text-white font-bold mb-4">Dit evenement is afgelast.</p>
                                ) : events[readMeEventIndex].status === 'gepland' && (
                                    <>
                                        <p className="text-sm text-white font-bold mb-4">Doorlopend evenement.</p>
                                        <div className="text-center">
                                            {events[readMeEventIndex].event_link ? (
                                                <a href={events[readMeEventIndex].event_link} target="_blank" rel="noopener noreferrer" className="inline-block bg-yellow-400 hover:bg-yellow-500 transition duration-200 text-white px-6 py-3 rounded font-semibold focus:outline-none focus:ring-2 focus:ring-yellow-300">
                                                    Aanmelden
                                                </a>
                                            ) : (
                                                <p className="text-sm text-white">Geen aanmeldlink beschikbaar.</p>
                                            )}
                                        </div>
                                    </>
                                )}
                            </article>
                        </div>
                    )}
                </div>
            </main>
        </NavBar>
    );
}
