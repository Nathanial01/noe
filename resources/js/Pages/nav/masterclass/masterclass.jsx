import React, { useState } from "react";
import { Head, usePage } from "@inertiajs/react";
import NavBar from "@/Layouts/NavBar.jsx";

export default function AgendaEvent() {
    const { events: serverEvents } = usePage().props;
    const [selectedEventIndex, setSelectedEventIndex] = useState(null);
    const [readMeEventIndex, setReadMeEventIndex] = useState(null);

    const selectedEvent =
        typeof selectedEventIndex === "number" && serverEvents[selectedEventIndex]
            ? serverEvents[selectedEventIndex]
            : null;

    const formatDate = (dateStr) => {
        const d = new Date(dateStr);
        return `${d.getDate().toString().padStart(2, "0")}-${(d.getMonth() + 1)
            .toString()
            .padStart(2, "0")}-${d.getFullYear()}`;
    };

    const eventDates = (event) => {
        const start = formatDate(event.start_date);
        const end = formatDate(event.end_date);
        return start !== end ? `van ${start} tot ${end}` : `van ${start}`;
    };

    const getStatusClass = (status) => {
        switch (status) {
            case "geannuleerd":
                return "text-red-500";
            case "gepland":
                return "text-green-600";
            case "afgelopen":
                return "text-blue-500";
            default:
                return "text-gray-500";
        }
    };

    const selectEvent = (index) => setSelectedEventIndex(index);
    const closeSelectEvent = () => setSelectedEventIndex(null);
    const openReadMeModal = (index) => setReadMeEventIndex(index);
    const closeReadMeModal = () => setReadMeEventIndex(null);

    const extraLinks = [
        { title: "Webinar", subtitle: "Live Session", link: "/website/webinar/index" },
        { title: "Agenda", subtitle: "Upcoming Events", link: "/website/eventagenda/index" },
        { title: "Masterclass", subtitle: "In-Depth Class", link: "/website/masterclass/index" },
    ];

    return (
        <NavBar>
            <Head title="Agenda Evenementen" />
            <main className="min-h-screen py-8 px-4 text-white">
                {/* Intro Sectie */}
                <section className="max-w-lg mx-auto text-center px-4 mt-24 mb-8">
                    <h1 className="text-3xl md:text-4xl font-bold mb-4">Agenda</h1>
                    <p className="leading-relaxed">
                        Bekijk de agenda en meld je aan voor een event bij jou in de buurt of online!
                    </p>
                </section>

                {/* Hoofdcontainer */}
                <div className={`max-w-7xl mx-auto ${selectedEvent ? "flex flex-col md:flex-row gap-6" : "max-w-2xl"}`}>
                    {/* Linker kolom: Evenementenlijst */}
                    {serverEvents.length > 0 ? (
                        <section className={selectedEvent ? "w-full md:w-1/2 space-y-4" : "w-full space-y-4"}>
                            <h1 className="text-3xl font-bold mb-8">Evenementen</h1>
                            {serverEvents.map((event, index) => (
                                <article
                                    key={index}
                                    className={`bg-gray-800 p-4 rounded-lg cursor-pointer ${
                                        selectedEventIndex === index ? "ring-4 ring-yellow-300" : ""
                                    }`}
                                    onClick={() => selectEvent(index)}
                                >
                                    <h2 className="font-bold text-lg">{event.title}</h2>
                                    <p className="text-sm">
                                        {eventDates(event)} | {event.start_time} - {event.end_time} | {event.place}
                                    </p>
                                    <p className="text-xs mt-2 opacity-70">{event.description.slice(0, 60)}...</p>
                                    {event.event_link && (
                                        <p className="text-xs mt-2">
                                            <a href={event.event_link} target="_blank" className="text-blue-500 underline">
                                                Bekijk evenement
                                            </a>
                                        </p>
                                    )}
                                    <div className="mt-4 flex justify-between">
                                        <p className={`text-xs ${getStatusClass(event.status)}`}>{event.status}</p>
                                        <button
                                            className="text-xs md:text-sm text-gray-400 hover:underline"
                                            onClick={(e) => {
                                                e.stopPropagation();
                                                openReadMeModal(index);
                                            }}
                                        >
                                            Lees verder...
                                        </button>
                                    </div>
                                </article>
                            ))}
                        </section>
                    ) : (
                        // Geen evenementen beschikbaar, toon extra links
                        <div className="flex flex-wrap gap-6 justify-center items-center">
                            {extraLinks.map((link, index) => (
                                <a key={index} href={link.link} className="cursor-pointer">
                                    <div className="group flex flex-col gap-4 w-32 h-40 bg-gray-800 rounded-2xl p-4 shadow-xl transition-all hover:border-indigo-500 hover:shadow-indigo-500/20">
                                        <div className="text-center">
                                            <p className="font-medium text-sm group-hover:text-indigo-400">{link.title}</p>
                                            <p className="text-xs mt-1 opacity-60 group-hover:opacity-100">{link.subtitle}</p>
                                        </div>
                                    </div>
                                </a>
                            ))}
                        </div>
                    )}

                    {/* Rechter kolom: Evenementdetails */}
                    {selectedEvent && (
                        <section className="hidden md:block w-full md:w-1/2 bg-gray-800 rounded-lg p-6 mt-16">
                            <h2 className="font-bold text-xl">{selectedEvent.title}</h2>
                            {selectedEvent.event_link && (
                                <p className="text-sm text-blue-400 mb-2">
                                    <a href={selectedEvent.event_link} target="_blank" className="underline">
                                        Bekijk evenement
                                    </a>
                                </p>
                            )}
                            <p className="text-sm opacity-80">
                                {eventDates(selectedEvent)} | {selectedEvent.start_time} - {selectedEvent.end_time} | {selectedEvent.place}
                            </p>
                            <p className="text-sm leading-relaxed mt-4">{selectedEvent.description}</p>
                        </section>
                    )}
                </div>

                {/* Lees verder pop-up */}
                {readMeEventIndex !== null && serverEvents[readMeEventIndex] && (
                    <div className="fixed inset-0 flex items-center justify-center z-50">
                        <div className="fixed inset-0 bg-black opacity-50" onClick={closeReadMeModal}></div>
                        <div className="bg-gray-800 p-6 rounded-lg max-w-md z-50">
                            <button className="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl" onClick={closeReadMeModal}>
                                &times;
                            </button>
                            <h2 className="font-bold text-xl">{serverEvents[readMeEventIndex].title}</h2>
                            <p className="text-sm opacity-80">
                                {eventDates(serverEvents[readMeEventIndex])} | {serverEvents[readMeEventIndex].start_time} - {serverEvents[readMeEventIndex].end_time} |{" "}
                                {serverEvents[readMeEventIndex].place}
                            </p>
                            <p className="text-sm leading-relaxed mt-4">{serverEvents[readMeEventIndex].description}</p>
                        </div>
                    </div>
                )}
            </main>
        </NavBar>
    );
}
