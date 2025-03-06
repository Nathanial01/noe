import React from "react";
import NavBar from "@/Layouts/NavBar";

export default function PrivateEquityHome() {
    return (
        <NavBar>
            <section className="mt-44">
                {/* ======================================================= */}
                {/* Hero Section */}
                {/* ======================================================= */}
                <div className="relative isolate overflow-hidden bg-none ">
                    <div className="px-6 py-24 sm:px-6 sm:py-32 lg:px-8">
                        <div className="mx-auto max-w-2xl text-center">
                            <h2 className="text-4xl font-semibold tracking-tight text-balance text-white sm:text-5xl">
                                Boost your productivity. Start using our app today.
                            </h2>
                            <p className="mx-auto mt-6 max-w-xl text-lg/8 text-pretty text-gray-300">
                                Incididunt sint fugiat pariatur cupidatat consectetur sit cillum anim id veniam aliqua proident excepteur
                                commodo do ea.
                            </p>
                            <div className="mt-10 flex items-center justify-center gap-x-6">
                                <a
                                    href="#"
                                    className="rounded-md bg-white px-3.5 py-2.5 text-sm font-semibold text-gray-900 shadow-xs hover:bg-gray-100 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"
                                >
                                    Get started
                                </a>
                                <a href="#" className="text-sm/6 font-semibold text-white">
                                    Learn more <span aria-hidden="true">→</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <svg
                        viewBox="0 0 1024 1024"
                        aria-hidden="true"
                        className="absolute top-1/2 left-1/2 -z-10 size-[64rem] -translate-x-1/2 [mask-image:radial-gradient(closest-side,white,transparent)]"
                    >
                        <circle r={512} cx={512} cy={512} fill="url(#8d958450-c69f-4251-94bc-4e091a323369)" fillOpacity="0.7" />
                        <defs>
                            <radialGradient id="8d958450-c69f-4251-94bc-4e091a323369">
                                <stop stopColor="#7775D6" />
                                <stop offset={1} stopColor="#E935C1" />
                            </radialGradient>
                        </defs>
                    </svg>
                </div>
                {/* ======================================================= */}
                {/* End Hero Section */}
                {/* ======================================================= */}


                {/* ======================================================= */}
                {/* Investment Highlights Section */}
                {/* ======================================================= */}
                <div className="py-16">
                    <div className="max-w-6xl mx-auto px-6">
                        <h2 className="text-3xl md:text-4xl font-bold text-center text-gray-50">
                            How We Create Value
                        </h2>
                        <div className="mt-10 grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div className="p-8 bg-gray-50 rounded-lg shadow hover:shadow-lg transition duration-300">
                                <h3 className="text-xl font-semibold text-[#5B1FAD]">
                                    Extensive Network
                                </h3>
                                <p className="mt-4 text-gray-600">
                                    We connect businesses with the right people, leveraging a global network of industry leaders, investors, and strategic partners.
                                </p>
                            </div>
                            <div className="p-8 bg-gray-50 rounded-lg shadow hover:shadow-lg transition duration-300">
                                <h3 className="text-xl font-semibold text-[#5B1FAD]">
                                    Expert Analysis
                                </h3>
                                <p className="mt-4 text-gray-600">
                                    Every investment is backed by rigorous market research and data-driven insights, ensuring informed and high-impact decisions.
                                </p>
                            </div>
                            <div className="p-8 bg-gray-50 rounded-lg shadow hover:shadow-lg transition duration-300">
                                <h3 className="text-xl font-semibold text-[#5B1FAD]">
                                    Teamwork Always Wins
                                </h3>
                                <p className="mt-4 text-gray-600">
                                    We work alongside founders and executives to create real, lasting value through collaboration.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                {/* ======================================================= */}
                {/* End Investment Highlights Section */}
                {/* ======================================================= */}

                {/* ======================================================= */}
                {/* Our Approach Section */}
                {/* ======================================================= */}
                <div id="learn-more" className="py-16 bg-gray-100">
                    <div className="max-w-6xl mx-auto px-6">
                        <h2 className="text-3xl md:text-4xl font-bold text-center text-[#5B1FAD]">
                            Our Approach: Strategic Growth &amp; Value Creation
                        </h2>
                        <p className="mt-6 text-lg text-center text-gray-700 max-w-3xl mx-auto">
                            We invest smartly by identifying high-growth opportunities, infusing strategic capital, driving operational excellence, and building long-term value.
                        </p>
                        <div className="mt-10 grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div className="p-8 bg-white rounded-lg shadow hover:shadow-lg transition duration-300">
                                <h3 className="text-xl font-semibold text-[#5B1FAD]">
                                    Identifying High-Growth Potential
                                </h3>
                                <p className="mt-2 text-gray-600">
                                    We seek businesses with scalability, strong leadership, and market demand.
                                </p>
                            </div>
                            <div className="p-8 bg-white rounded-lg shadow hover:shadow-lg transition duration-300">
                                <h3 className="text-xl font-semibold text-[#5B1FAD]">
                                    Infusing Strategic Capital
                                </h3>
                                <p className="mt-2 text-gray-600">
                                    Our funding fuels expansion, acquisitions, and innovation.
                                </p>
                            </div>
                            <div className="p-8 bg-white rounded-lg shadow hover:shadow-lg transition duration-300">
                                <h3 className="text-xl font-semibold text-[#5B1FAD]">
                                    Driving Operational Excellence
                                </h3>
                                <p className="mt-2 text-gray-600">
                                    We optimize operations and market positioning to maximize growth.
                                </p>
                            </div>
                            <div className="p-8 bg-white rounded-lg shadow hover:shadow-lg transition duration-300">
                                <h3 className="text-xl font-semibold text-[#5B1FAD]">
                                    Building Long-Term Value
                                </h3>
                                <p className="mt-2 text-gray-600">
                                    Every investment is designed for sustainable growth and profitability.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                {/* ======================================================= */}
                {/* End Our Approach Section */}
                {/* ======================================================= */}

                {/* ======================================================= */}
                {/* Process Section */}
                {/* ======================================================= */}
                <div className="py-16 ">
                    <div className="max-w-6xl mx-auto px-6 ">
                        <h2 className="text-3xl md:text-4xl font-bold text-center text-gray-50">
                            Our Process
                        </h2>
                        <div className="mt-10 ">
                            <ol className="relative border-l border-white">
                                <li className="mb-10 ml-6">
                                    <span className="absolute flex items-center justify-center w-6 h-6 bg-none   rounded-full -left-3 ring-8 ring-white bg-indigo-700"></span>
                                    <h3 className="mb-1 text-xl font-semibold text-gray-50">
                                        Discovery &amp; Analysis
                                    </h3>
                                    <p className="text-gray-50">
                                        In-depth research to identify the best opportunities in the market.
                                    </p>
                                </li>
                                <li className="mb-10 ml-6 ">
                                    <span className="absolute flex items-center justify-center w-6 h-6 bg-none rounded-full -left-3 ring-8 ring-white bg-indigo-700"></span>
                                    <h3 className="mb-1 text-xl font-semibold text-gray-50">
                                        Strategy Development
                                    </h3>
                                    <p className="text-gray-50">
                                        Crafting a comprehensive strategy that aligns with your investment goals.
                                    </p>
                                </li>
                                <li className="mb-10 ml-6">
                                    <span className="absolute flex items-center justify-center w-6 h-6 bg-none rounded-full -left-3 ring-8 ring-white bg-indigo-700"></span>
                                    <h3 className="mb-1 text-xl font-semibold text-gray-50">
                                        Execution &amp; Monitoring
                                    </h3>
                                    <p className="text-gray-50">
                                        Implementing the strategy with ongoing performance reviews.
                                    </p>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                {/* ======================================================= */}
                {/* End Process Section */}
                {/* ======================================================= */}

                {/* ======================================================= */}
                {/* Testimonials Section */}
                {/* ======================================================= */}
                <div className="py-16 card-dark">
                    <div className="max-w-6xl mx-auto px-6">
                        <h2 className="text-3xl md:text-4xl font-bold text-center text-gray-50">
                            What Our Clients Say
                        </h2>
                        <div className="mt-10 grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div className="p-8 bg-white rounded-lg shadow hover:shadow-lg transition duration-300">
                                <p className="text-gray-600">
                                    "Their expertise and strategic approach have been instrumental in growing our portfolio. Highly recommended!"
                                </p>
                                <div className="mt-4">
                                    <span className="font-semibold text-[#5B1FAD]">John Doe</span>
                                    <span className="text-gray-500">, CEO, Company A</span>
                                </div>
                            </div>
                            <div className="p-8 bg-white rounded-lg shadow hover:shadow-lg transition duration-300">
                                <p className="text-gray-600">
                                    "A trusted partner in private equity, delivering consistent results and innovative strategies."
                                </p>
                                <div className="mt-4">
                                    <span className="font-semibold text-[#5B1FAD]">Jane Smith</span>
                                    <span className="text-gray-500">, Managing Director, Company B</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {/* ======================================================= */}
                {/* End Testimonials Section */}
                {/* ======================================================= */}

                {/* ======================================================= */}
                {/* Partners Section */}
                {/* ======================================================= */}
                <div className="py-16">
                    <div className="max-w-6xl mx-auto px-6 text-center">
                        <h2 className="text-3xl md:text-4xl font-bold text-gray-50">
                            Our Partners
                        </h2>
                        <div className="mt-10 flex flex-wrap justify-center gap-8">
                            <img src="/images/partner1.png" alt="Partner 1" className="h-12" />
                            <img src="/images/partner2.png" alt="Partner 2" className="h-12" />
                            <img src="/images/partner3.png" alt="Partner 3" className="h-12" />
                            <img src="/images/partner4.png" alt="Partner 4" className="h-12" />
                            <img src="/images/partner5.png" alt="Partner 5" className="h-12" />
                        </div>
                    </div>
                </div>
                {/* ======================================================= */}
                {/* End Partners Section */}
                {/* ======================================================= */}

                {/* ======================================================= */}
                {/* Additional Insights Section */}
                {/* ======================================================= */}
                <div className="py-16 card-dark">
                    <div className="max-w-6xl mx-auto px-6">
                        <h2 className="text-3xl md:text-4xl font-bold text-center text-gray-50">
                            Latest Insights
                        </h2>
                        <p className="mt-6 text-lg text-center text-gray-50 max-w-3xl mx-auto">
                            Stay informed with the latest trends and insights in the private equity landscape.
                        </p>
                        <div className="mt-10 grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div className="p-8 bg-white rounded-lg shadow hover:shadow-lg transition duration-300">
                                <img
                                    src="/images/insight1.jpg"
                                    alt="Insight 1"
                                    className="w-full h-48 object-cover rounded-md"
                                />
                                <h3 className="mt-4 text-xl font-semibold text-[#5B1FAD]">
                                    Market Trends 2025
                                </h3>
                                <p className="mt-2 text-gray-600">
                                    A deep dive into the emerging trends that are shaping the private equity market.
                                </p>
                                <a href="#" className="mt-4 inline-block text-[#5B1FAD] font-semibold hover:underline">
                                    Read More &rarr;
                                </a>
                            </div>
                            <div className="p-8 bg-white rounded-lg shadow hover:shadow-lg transition duration-300">
                                <img
                                    src="/images/insight2.jpg"
                                    alt="Insight 2"
                                    className="w-full h-48 object-cover rounded-md"
                                />
                                <h3 className="mt-4 text-xl font-semibold text-[#5B1FAD]">
                                    Innovation in Investments
                                </h3>
                                <p className="mt-2 text-gray-600">
                                    How technological advancements are reshaping investment strategies.
                                </p>
                                <a href="#" className="mt-4 inline-block text-[#5B1FAD] font-semibold hover:underline">
                                    Read More &rarr;
                                </a>
                            </div>
                            <div className="p-8 bg-white rounded-lg shadow hover:shadow-lg transition duration-300">
                                <img
                                    src="/images/insight3.jpg"
                                    alt="Insight 3"
                                    className="w-full h-48 object-cover rounded-md"
                                />
                                <h3 className="mt-4 text-xl font-semibold text-[#5B1FAD]">
                                    Private Equity Outlook
                                </h3>
                                <p className="mt-2 text-gray-600">
                                    Expert analysis on the future trajectory of private equity investments.
                                </p>
                                <a href="#" className="mt-4 inline-block text-[#5B1FAD] font-semibold hover:underline">
                                    Read More &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                {/* ======================================================= */}
                {/* End Additional Insights Section */}
                {/* ======================================================= */}

                {/* ======================================================= */}
                {/* Team Section */}
                {/* ======================================================= */}
                <div className="py-16 ">
                    <div className="max-w-6xl mx-auto px-6">
                        <h2 className="text-3xl md:text-4xl font-bold text-center text-gray-50">
                            Meet Our Team
                        </h2>
                        <p className="mt-6 text-lg text-center text-gray-50 max-w-3xl mx-auto">
                            Our team of experts is dedicated to driving success and delivering outstanding results.
                        </p>
                        <div className="mt-10 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                            <div className="p-6 bg-gray-50 rounded-lg shadow hover:shadow-lg transition duration-300 text-center">
                                <img
                                    src="/images/team1.jpg"
                                    alt="Team Member 1"
                                    className="w-24 h-24 rounded-full mx-auto"
                                />
                                <h3 className="mt-4 text-xl font-semibold text-[#5B1FAD]">
                                    Alice Johnson
                                </h3>
                                <p className="text-gray-600">Chief Investment Officer</p>
                            </div>
                            <div className="p-6 bg-gray-50 rounded-lg shadow hover:shadow-lg transition duration-300 text-center">
                                <img
                                    src="/images/team2.jpg"
                                    alt="Team Member 2"
                                    className="w-24 h-24 rounded-full mx-auto"
                                />
                                <h3 className="mt-4 text-xl font-semibold text-[#5B1FAD]">
                                    Robert Smith
                                </h3>
                                <p className="text-gray-600">Head of Research</p>
                            </div>
                            <div className="p-6 bg-gray-50 rounded-lg shadow hover:shadow-lg transition duration-300 text-center">
                                <img
                                    src="/images/team3.jpg"
                                    alt="Team Member 3"
                                    className="w-24 h-24 rounded-full mx-auto"
                                />
                                <h3 className="mt-4 text-xl font-semibold text-[#5B1FAD]">
                                    Emily Davis
                                </h3>
                                <p className="text-gray-600">Portfolio Manager</p>
                            </div>
                        </div>
                    </div>
                </div>
                {/* ======================================================= */}
                {/* End Team Section */}
                {/* ======================================================= */}

                {/* ======================================================= */}
                {/* FAQs Section */}
                {/* ======================================================= */}
                <div className="py-16 card-dark">
                    <div className="max-w-6xl mx-auto px-6">
                        <h2 className="text-3xl md:text-4xl font-bold text-center text-gray-50">
                            Frequently Asked Questions
                        </h2>
                        <div className="mt-10 space-y-6">
                            <div className="p-6 bg-white rounded-lg shadow hover:shadow-lg transition duration-300">
                                <h3 className="text-xl font-semibold text-[#5B1FAD]">
                                    What is Private Equity?
                                </h3>
                                <p className="mt-2 text-gray-600">
                                    Private equity involves investments in private companies or taking public companies private, focusing on long-term growth and value creation.
                                </p>
                            </div>
                            <div className="p-6 bg-white rounded-lg shadow hover:shadow-lg transition duration-300">
                                <h3 className="text-xl font-semibold text-[#5B1FAD]">
                                    How do you select investment opportunities?
                                </h3>
                                <p className="mt-2 text-gray-600">
                                    We perform rigorous due diligence, market analysis, and leverage our extensive network to identify the best opportunities.
                                </p>
                            </div>
                            <div className="p-6 bg-white rounded-lg shadow hover:shadow-lg transition duration-300">
                                <h3 className="text-xl font-semibold text-[#5B1FAD]">
                                    What is your investment horizon?
                                </h3>
                                <p className="mt-2 text-gray-600">
                                    Our strategies are designed for long-term value creation, typically spanning 5 to 10 years.
                                </p>
                            </div>
                            <div className="p-6 bg-white rounded-lg shadow hover:shadow-lg transition duration-300">
                                <h3 className="text-xl font-semibold text-[#5B1FAD]">
                                    How can I get started?
                                </h3>
                                <p className="mt-2 text-gray-600">
                                    Reach out to our team using the contact form in the Call to Action section to discuss potential opportunities.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                {/* ======================================================= */}
                {/* End FAQs Section */}
                {/* ======================================================= */}

                {/* ======================================================= */}
                {/* Call to Action Section */}
                {/* ======================================================= */}
                <div id="contact" className="py-16 ">
                    <div className="max-w-6xl mx-auto px-6 text-center">
                        <h2 className="text-4xl md:text-5xl font-bold text-white">
                            Elevate Your Portfolio
                        </h2>
                        <p className="mt-6 text-lg text-white max-w-2xl mx-auto">
                            Partner with us to unlock exclusive investment opportunities and drive exceptional returns.
                        </p>
                        <div className="mt-10">
                            <a
                                href="#"
                                className="px-8 py-3 bg-white text-[#5B1FAD] rounded-md font-semibold hover:bg-gray-100 transition duration-300"
                            >
                                Get In Touch
                            </a>
                        </div>
                    </div>
                </div>
                {/* ======================================================= */}
                {/* End Call to Action Section */}
            </section>
        </NavBar>
    );
}
