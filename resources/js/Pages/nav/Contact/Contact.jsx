import React, { useState } from "react";
import axios from "axios";
import NavBar from "@/Layouts/NavBar";
import Background from "@/Components/Background.jsx";

export default function Contact() {
    const [formData, setFormData] = useState({
        first_name: "",
        last_name: "",
        email: "",
        phone: "",
        message: "",
    });
    const [toast, setToast] = useState(null);
    const [error, setError] = useState(null);

    const handleChange = (e) => {
        setFormData({ ...formData, [e.target.id]: e.target.value });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setError(null);
        try {
            await axios.post("/contact", formData);
            // Show success toast in the middle, bigger.
            setToast("Bericht succesvol verzonden!");
            // Clear the form
            setFormData({
                first_name: "",
                last_name: "",
                email: "",
                phone: "",
                message: "",
            });
            // Remove toast after 3 seconds
            setTimeout(() => {
                setToast(null);
            }, 3000);
        } catch (err) {
            setError("Fout bij het verzenden van het bericht. Probeer opnieuw.");
            console.error("Contact form error:", err);
        }
    };

    return (
        <NavBar>
            {/* Toast Popup in the middle */}
            {toast && (
                <div className="fixed left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 p-8 bg-green-500 text-white rounded-lg shadow-xl text-2xl">
                    {toast}
                </div>
            )}

            <div className="min-h-screen bg-none flex items-center justify-center px-8">
                <div className="rounded-lg flex flex-col lg:flex-row max-w-6xl w-full overflow-hidden">
                    {/* Left-side static content */}
                    <div className="w-full rounded-lg lg:w-1/3 z-10 backdrop-blur-3xl text-gray-50 p-8 flex flex-col justify-between">
                        <h2 className="text-4xl font-extrabold text-gray-100 mt-6 mb-6">
                            Neem contact op
                        </h2>
                        <ul className="space-y-6">
                            <li className="flex items-center space-x-3">
                                <i className="bi bi-geo-alt text-gray-50"></i>
                                <div>
                                    <p className="font-semibold text-gray-50">Bezoek ons</p>
                                    <p className="text-gray-50">
                                        67 Wisteria Way, Croydon South VIC 3136 AU
                                    </p>
                                </div>
                            </li>
                            <li className="flex items-center space-x-3">
                                <i className="bi bi-chat-dots text-gray-50"></i>
                                <div>
                                    <p className="font-semibold text-gray-50">Chat met ons</p>
                                    <a href="mailto:hello@paysphere.com" className="text-gray-50">
                                        info@noe.com
                                    </a>
                                </div>
                            </li>
                            <li className="flex items-center space-x-3">
                                <i className="bi bi-telephone text-gray-50"></i>
                                <div>
                                    <p className="font-semibold text-gray-50">Bel ons</p>
                                    <p className="text-gray-50">Ma-Vr 8:00 - 17:00</p>
                                    <p className="text-gray-50">(+995) 555-55-55-55</p>
                                </div>
                            </li>
                        </ul>
                        <div className="mt-12 mb-24">
                            <p className="font-semibold text-gray-50">Onze Locatie:</p>
                            <iframe
                                className="w-full h-64 rounded-lg"
                                src="https://www.google.com/maps/embed/v1/place?q=67+Wisteria+Way,+Croydon+South+VIC+3136+AU&key=YOUR_GOOGLE_MAPS_API_KEY"
                                allowFullScreen=""
                                loading="lazy"
                            ></iframe>
                        </div>
                        <div className="mt-8 flex justify-center space-x-4">
                            <a href="#" className="hover:opacity-80">
                                <i className="bi bi-facebook text-2xl text-gray-50"></i>
                            </a>
                            <a href="#" className="hover:opacity-80">
                                <i className="bi bi-twitter text-2xl text-gray-50"></i>
                            </a>
                            <a href="#" className="hover:opacity-80">
                                <i className="bi bi-linkedin text-2xl text-gray-50"></i>
                            </a>
                            <a href="#" className="hover:opacity-80">
                                <i className="bi bi-instagram text-2xl text-gray-50"></i>
                            </a>
                            <a href="#" className="hover:opacity-80">
                                <i className="bi bi-youtube text-2xl text-gray-50"></i>
                            </a>
                            <a href="#" className="hover:opacity-80">
                                <i className="bi bi-github text-2xl text-gray-50"></i>
                            </a>
                        </div>
                    </div>

                    {/* Right-side form */}
                    <div className="w-full lg:w-2/3 bg-none p-12">
                        <h2 className="text-4xl font-bold text-gray-900 dark:text-white mb-8">
                            Stuur ons een bericht
                        </h2>

                        {/* Error Message */}
                        {error && (
                            <div className="mb-6">
                <span className="text-red-500 text-lg font-semibold">
                  {error}
                </span>
                            </div>
                        )}

                        <form onSubmit={handleSubmit} className="space-y-8">
                            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div className="relative">
                                    <input
                                        type="text"
                                        id="first_name"
                                        placeholder=" "
                                        value={formData.first_name}
                                        onChange={handleChange}
                                        className="w-full h-14 px-4 rounded-lg backdrop-blur-xl text-white border border-[#FC0] dark:border-[#5B1FAD] focus:outline-none peer bg-transparent"
                                        required
                                    />
                                    <label
                                        htmlFor="first_name"
                                        className="absolute left-4 top-1/2 transform -translate-y-1/2 text-white transition-all duration-200 peer-placeholder-shown:text-lg peer-placeholder-shown:text-gray-400 peer-focus:text-white peer-focus:text-sm peer-focus:top-0"
                                    >
                                        Voornaam
                                    </label>
                                </div>
                                <div className="relative">
                                    <input
                                        type="text"
                                        id="last_name"
                                        placeholder=" "
                                        value={formData.last_name}
                                        onChange={handleChange}
                                        className="w-full h-14 px-4 rounded-lg backdrop-blur-xl text-white border border-[#FC0] dark:border-[#5B1FAD] focus:outline-none peer bg-transparent"
                                    />
                                    <label
                                        htmlFor="last_name"
                                        className="absolute left-4 top-1/2 transform -translate-y-1/2 text-white transition-all duration-200 peer-placeholder-shown:text-lg peer-placeholder-shown:text-gray-400 peer-focus:text-white peer-focus:text-sm peer-focus:top-0"
                                    >
                                        Achternaam
                                    </label>
                                </div>
                            </div>
                            <div className="relative">
                                <input
                                    type="email"
                                    id="email"
                                    placeholder=" "
                                    value={formData.email}
                                    onChange={handleChange}
                                    className="w-full h-14 px-4 rounded-lg backdrop-blur-xl text-white border border-[#FC0] dark:border-[#5B1FAD] focus:outline-none peer bg-transparent"
                                    required
                                />
                                <label
                                    htmlFor="email"
                                    className="absolute left-4 top-1/2 transform -translate-y-1/2 text-white transition-all duration-200 peer-placeholder-shown:text-lg peer-placeholder-shown:text-gray-400 peer-focus:text-white peer-focus:text-sm peer-focus:top-0"
                                >
                                    E-mailadres
                                </label>
                            </div>
                            <div className="relative">
                                <input
                                    type="tel"
                                    id="phone"
                                    placeholder=" "
                                    value={formData.phone}
                                    onChange={handleChange}
                                    className="w-full h-14 px-4 rounded-lg backdrop-blur-xl text-white border border-[#FC0] dark:border-[#5B1FAD] focus:outline-none peer bg-transparent"
                                />
                                <label
                                    htmlFor="phone"
                                    className="absolute left-4 top-1/2 transform -translate-y-1/2 text-white transition-all duration-200 peer-placeholder-shown:text-lg peer-placeholder-shown:text-gray-400 peer-focus:text-white peer-focus:text-sm peer-focus:top-0"
                                >
                                    Telefoonnummer
                                </label>
                            </div>
                            <div className="relative">
                <textarea
                    id="message"
                    rows="5"
                    placeholder=" "
                    value={formData.message}
                    onChange={handleChange}
                    className="w-full px-4 py-3 rounded-lg backdrop-blur-xl text-white border border-[#FC0] dark:border-[#5B1FAD] focus:outline-none peer bg-transparent"
                    required
                ></textarea>
                                <label
                                    htmlFor="message"
                                    className="absolute left-4 text-white transition-all duration-200 peer-placeholder-shown:text-lg peer-placeholder-shown:text-gray-400 peer-focus:text-white peer-focus:text-sm peer-focus:top-0"
                                >
                                    Typ hier je bericht
                                </label>
                            </div>
                            <div className="flex items-center">
                                <input
                                    type="checkbox"
                                    id="privacy_policy"
                                    className="w-5 h-5 rounded border-[#FC0] bg-transparent text-white dark:ring-[#5B1FAD]"
                                    required
                                />
                                <label
                                    htmlFor="privacy_policy"
                                    className="text-white text-sm ml-3"
                                >
                                    Ik ga akkoord met de{" "}
                                    <a href="#" className="underline">
                                        Privacy Policy
                                    </a>
                                </label>
                            </div>
                            <button
                                type="submit"
                                className="group relative flex items-center justify-center w-full h-14 px-5 rounded-full font-semibold text-white uppercase bg-transparent border-0 overflow-hidden transition-all duration-300 ease-in-out z-10"
                            >
                <span className="text whitespace-nowrap leading-5 pr-11 z-20">
                  Bericht versturen
                </span>
                                <span className="icon absolute top-1/2 right-2 transform -translate-y-1/2 w-12 h-8 flex items-center justify-center rounded-full z-20">
                  <svg
                      viewBox="0 0 512 512"
                      xmlns="http://www.w3.org/2000/svg"
                      data-icon="paper-plane"
                      width="25px"
                      aria-hidden="true"
                      className="text-white fill-current"
                  >
                    <path d="M476 3.2L12.5 270.6c-18.1 10.4-15.8 35.6 2.2 43.2L121 358.4l287.3-253.2c5.5-4.9 13.3 2.6 8.6 8.3L176 407v80.5c0 23.6 28.5 32.9 42.5 15.8L282 426l124.6 52.2c14.2 6 30.4-2.9 33-18.2l72-432C515 7.8 493.3-6.8 476 3.2z"></path>
                  </svg>
                </span>
                                <span className="button-after absolute inset-0 border-2 border-[#FC0] dark:border-[#5B1FAD] rounded-full z-10"></span>
                                <span className="button-before absolute inset-0 bg-[#FC0] dark:bg-[#5B1FAD] z-0 transform translate-x-[90%] transition-transform duration-300 ease-out group-hover:translate-x-0"></span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </NavBar>
    );
}
