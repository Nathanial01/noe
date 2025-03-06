import React from "react";
import NavBar from "@/Layouts/NavBar";
import Footer from "@/Components/Footer";

export default function RealEstatePage() {
    const stats = [
        { id: 1, name: 'Creators on the platform', value: '8,000+' },
        { id: 2, name: 'Flat platform fee', value: '3%' },
        { id: 3, name: 'Uptime guarantee', value: '99.9%' },
        { id: 4, name: 'Paid out to creators', value: '$70M' },
    ]
    return (
        <NavBar>
            <section>
                {/* HERO SECTION */}
                <div className="relative h-[80vh] flex items-center justify-center ">
                    {/* Backdrop blur instead of a background image */}
                    <div className="absolute inset-0 backdrop-blur-lg"></div>
                    <div className="relative z-10 flex flex-col items-center justify-center text-center px-4 py-20">
                        <h1 className="text-4xl md:text-7xl font-bold text-white animate-fadeIn">
                            Strategic Real Estate Investments with Noé Capital
                        </h1>
                        <p className="mt-4 text-lg md:text-xl text-white max-w-2xl animate-fadeIn delay-200">
                            Transforming Prime Locations into Premier Investments
                        </p>
                        <div className="mt-10">
                            <a
                                href="#portfolio"
                                className="px-8 py-3 bg-[#5B1FAD] text-white rounded-md font-semibold hover:bg-[#4a1a8b] transition duration-300"
                            >
                                Explore Our Portfolio
                            </a>
                        </div>
                    </div>
                </div>

                {/* ABOUT OUR REAL ESTATE INVESTMENTS */}
                <div className="py-16 card-dark">
                    <div className="max-w-6xl mx-auto px-6">
                        <h2 className="text-3xl md:text-4xl font-bold text-center text-white">
                            About Our Real Estate Investments
                        </h2>
                        <p className="mt-6 text-lg text-center text-white max-w-3xl mx-auto">
                            At Noé Capital, we strategically invest in high-growth real estate markets, focusing on luxury residences, commercial properties, and hospitality investments. With a strong presence in Dubai, we identify and develop high-yield investment opportunities for long-term value creation. We don’t just acquire properties—we create lasting value.
                        </p>
                    </div>
                </div>

                {/* OUR INVESTMENT FOCUS */}
                <div className="py-16 card-dark">
                    <div className="max-w-6xl mx-auto px-6">
                        <h2 className="text-3xl md:text-4xl font-bold text-center text-white">
                            Our Investment Focus
                        </h2>
                        <div className="mt-10 grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div className="p-8 card-dark rounded-lg shadow hover:shadow-lg transition duration-300">
                                <h3 className="text-xl font-semibold text-white">
                                    Luxury Residences
                                </h3>
                                <p className="mt-4 text-white">
                                    High-end apartments, penthouses, and villas in prime locations with strong resale and rental demand.
                                </p>
                            </div>
                            <div className="p-8 card-dark rounded-lg shadow hover:shadow-lg transition duration-300">
                                <h3 className="text-xl font-semibold text-white">
                                    Commercial Properties
                                </h3>
                                <p className="mt-4 text-white">
                                    Strategic investments in office spaces, retail hubs, and mixed-use developments in thriving business districts.
                                </p>
                            </div>
                            <div className="p-8 card-dark rounded-lg shadow hover:shadow-lg transition duration-300">
                                <h3 className="text-xl font-semibold text-white">
                                    Hospitality &amp; Short-Term Rentals
                                </h3>
                                <p className="mt-4 text-white">
                                    Hotels, serviced apartments, and premium Airbnb properties in high-tourism destinations.
                                </p>
                            </div>
                            <div className="p-8 card-dark rounded-lg shadow hover:shadow-lg transition duration-300">
                                <h3 className="text-xl font-semibold text-white">
                                    Development Projects
                                </h3>
                                <p className="mt-4 text-white">
                                    Ground-up developments and strategic acquisitions, turning vision into lasting value.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {/* FEATURED PROPERTIES */}
                <div id="portfolio" className="py-16 card-dark">
                    <div className="max-w-6xl mx-auto px-6">
                        <h2 className="text-3xl md:text-4xl font-bold text-center text-white">
                            Featured Properties
                        </h2>
                        <div className="mt-10 grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div className="card-dark rounded-lg overflow-hidden shadow hover:shadow-lg transition duration-300">
                                <img
                                    src="/images/property1.jpg"
                                    alt="Property 1"
                                    className="w-full h-56 object-cover"
                                />
                                <div className="p-6">
                                    <h3 className="text-xl font-semibold text-white">
                                        Modern Urban Loft
                                    </h3>
                                    <p className="mt-2 text-white">
                                        Located in the heart of the city, offering stunning views and contemporary design.
                                    </p>
                                    <a
                                        href="#"
                                        className="mt-4 inline-block text-white font-semibold hover:underline"
                                    >
                                        Request More Info &rarr;
                                    </a>
                                </div>
                            </div>
                            <div className="card-dark rounded-lg overflow-hidden shadow hover:shadow-lg transition duration-300">
                                <img
                                    src="/images/property2.jpg"
                                    alt="Property 2"
                                    className="w-full h-56 object-cover"
                                />
                                <div className="p-6">
                                    <h3 className="text-xl font-semibold text-white">
                                        Luxury Suburban Home
                                    </h3>
                                    <p className="mt-2 text-white">
                                        A spacious estate in a tranquil neighborhood, perfect for families seeking comfort and style.
                                    </p>
                                    <a
                                        href="#"
                                        className="mt-4 inline-block text-white font-semibold hover:underline"
                                    >
                                        Request More Info &rarr;
                                    </a>
                                </div>
                            </div>
                            <div className="card-dark rounded-lg overflow-hidden shadow hover:shadow-lg transition duration-300">
                                <img
                                    src="/images/property3.jpg"
                                    alt="Property 3"
                                    className="w-full h-56 object-cover"
                                />
                                <div className="p-6">
                                    <h3 className="text-xl font-semibold text-white">
                                        Commercial Space
                                    </h3>
                                    <p className="mt-2 text-white">
                                        Ideal for businesses looking to establish a presence in a bustling commercial hub.
                                    </p>
                                    <a
                                        href="#"
                                        className="mt-4 inline-block text-white font-semibold hover:underline"
                                    >
                                        Request More Info &rarr;
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {/* WHY INVEST WITH NOÉ CAPITAL */}
                <div className="py-16 card-dark">
                    <div className="max-w-6xl mx-auto px-6">
                        <h2 className="text-3xl md:text-4xl font-bold text-center text-white">
                            Why Invest with Noé Capital?
                        </h2>
                        <div className="mt-10 grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div className="p-8 card-dark rounded-lg shadow hover:shadow-lg transition duration-300">
                                <h3 className="text-xl font-semibold text-white">
                                    Proven Track Record
                                </h3>
                                <p className="mt-4 text-white">
                                    A history of acquiring, developing, and scaling high-value real estate assets.
                                </p>
                            </div>
                            <div className="p-8 card-dark rounded-lg shadow hover:shadow-lg transition duration-300">
                                <h3 className="text-xl font-semibold text-white">
                                    Market Expertise
                                </h3>
                                <p className="mt-4 text-white">
                                    Deep understanding of Dubai and other high-growth real estate markets.
                                </p>
                            </div>
                            <div className="p-8 card-dark rounded-lg shadow hover:shadow-lg transition duration-300">
                                <h3 className="text-xl font-semibold text-white">
                                    Exclusive Off-Market Deals
                                </h3>
                                <p className="mt-4 text-white">
                                    Access to premium properties not available to the general public.
                                </p>
                            </div>
                            <div className="p-8 card-dark rounded-lg shadow hover:shadow-lg transition duration-300">
                                <h3 className="text-xl font-semibold text-white">
                                    High ROI Potential
                                </h3>
                                <p className="mt-4 text-white">
                                    Focused on strong capital appreciation and attractive rental yields.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {/* PARTNER WITH US */}
                <div className="card-dark py-24 sm:py-32">
                    <div className="mx-auto max-w-7xl px-6 lg:px-8">
                        <div className="mx-auto max-w-2xl lg:max-w-none">
                            <div className="text-center">
                                <h2 className="text-4xl font-semibold tracking-tight text-balance text-white sm:text-5xl">
                                    Trusted by creators worldwide
                                </h2>
                                <p className="mt-4 text-lg/8 text-white">
                                    Lorem ipsum dolor sit amet consect adipisicing possimus.
                                </p>
                            </div>
                            <dl className="mt-16 grid grid-cols-1 gap-0.5 overflow-hidden rounded-2xl text-center sm:grid-cols-2 lg:grid-cols-4">
                                {stats.map((stat) => (
                                    <div key={stat.id} className="flex flex-col bg-gray-400/5 p-8">
                                        <dt className="text-sm/6 font-semibold text-white">{stat.name}</dt>
                                        <dd className="order-first text-3xl font-semibold tracking-tight text-white">
                                            {stat.value}
                                        </dd>
                                    </div>
                                ))}
                            </dl>
                        </div>

                        <div className="mt-10">
                            <a
                                href="/contact"
                                className="px-8 py-3 card-dark text-white rounded-md font-semibold hover:bg-gray-100 transition duration-300"
                            >
                                Get in Touch
                            </a>
                        </div>
                    </div>
                </div>


            </section>
        </NavBar>
    );
}
