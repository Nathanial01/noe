    import React from "react";
import NavBar from "@/Layouts/NavBar";
import Footer from "@/Components/Footer";

export default function AboutUs() {
    return (
        <NavBar>
            <section>
                {/* ======================================================= */}
                {/* Hero Section */}
                {/* ======================================================= */}
                <div className="relative isolate overflow-hidden pt-14">

                    <div
                        aria-hidden="true"
                        className="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80"
                    >
                        <div
                            style={{
                                clipPath:
                                    'polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)',
                            }}
                            className="relative left-[calc(50%-11rem)] aspect-1155/678 w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-linear-to-tr from-[#ff80b5] to-[#9089fc] opacity-20 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"
                        />
                    </div>
                    <div className="mx-auto max-w-7xl px-6 lg:px-8">
                        <div className="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56">
                            <div className="hidden sm:mb-8 sm:flex sm:justify-center">
                                <div className="relative rounded-full px-3 py-1 text-sm/6 text-gray-400 ring-1 ring-white/10 hover:ring-white/20">
                                    Announcing our next round of funding.{' '}
                                    <a href="#" className="font-semibold text-white">
                                        <span aria-hidden="true" className="absolute inset-0" />
                                        Read more <span aria-hidden="true">&rarr;</span>
                                    </a>
                                </div>
                            </div>
                            <div className="text-center">
                                <h1 className="text-5xl font-semibold tracking-tight text-balance text-white sm:text-7xl">
                                    Data to enrich your online business
                                </h1>
                                <p className="mt-8 text-lg font-medium text-pretty text-gray-400 sm:text-xl/8">
                                    Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui lorem cupidatat commodo. Elit sunt amet
                                    fugiat veniam occaecat.
                                </p>
                                <div className="mt-10 flex items-center justify-center gap-x-6">
                                    <a
                                        href="#"
                                        className="rounded-md bg-indigo-500 px-3.5 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-400"
                                    >
                                        Get started
                                    </a>
                                    <a href="#" className="text-sm/6 font-semibold text-white">
                                        Learn more <span aria-hidden="true">→</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        aria-hidden="true"
                        className="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]"
                    >
                        <div
                            style={{
                                clipPath:
                                    'polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)',
                            }}
                            className="relative left-[calc(50%+3rem)] aspect-1155/678 w-[36.125rem] -translate-x-1/2 bg-linear-to-tr from-[#ff80b5] to-[#9089fc] opacity-20 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]"
                        />
                    </div>
                </div>
                {/* ======================================================= */}
                {/* End Hero Section */}
                {/* ======================================================= */}

                {/* ======================================================= */}
                {/* Company Overview Section */}
                {/* ======================================================= */}
                <div className="py-16 ">
                    <div className="max-w-6xl mx-auto px-6">
                        <h2 className="text-3xl md:text-4xl font-bold text-center text-gray-50">Our Story</h2>
                        <p className="mt-6 text-lg text-center text-gray-50 max-w-3xl mx-auto">
                            Founded on the principles of integrity and innovation, our company has grown into a leader in the industry.
                            We believe in harnessing expertise and leveraging cutting-edge technology to drive meaningful results.
                        </p>
                        <img src="/img/team/IMG_1855 1.png" alt="Team Image 4" className="w-full object-cover" />

                    </div>
                </div>
                {/* ======================================================= */}
                {/* End Company Overview Section */}
                {/* ======================================================= */}

                {/* ======================================================= */}
                {/* Mission & Vision Section */}
                {/* ======================================================= */}
                <div className="py-16 bg-gray-100">
                    <div className="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h3 className="text-2xl font-semibold text-[#5B1FAD]">Our Mission</h3>
                            <p className="mt-4 text-gray-600">
                                Our mission is to empower businesses by providing tailored solutions that drive growth, foster innovation, and create lasting value.
                                We are committed to excellence in every endeavor.
                            </p>
                        </div>
                        <div>
                            <h3 className="text-2xl font-semibold text-[#5B1FAD]">Our Vision</h3>
                            <p className="mt-4 text-gray-600">
                                We envision a future where strategic partnerships and innovative solutions converge to transform industries
                                and shape a better, more sustainable world for generations to come.
                            </p>
                        </div>
                    </div>
                </div>
                {/* ======================================================= */}
                {/* End Mission & Vision Section */}
                {/* ======================================================= */}

                {/* ======================================================= */}
                {/* Timeline / History Section */}
                {/* ======================================================= */}
                <div className="py-16 ">
                    <div className="max-w-6xl mx-auto px-6">
                        <h2 className="text-3xl md:text-4xl font-bold text-center text-gray-50">Our Journey</h2>
                        <div className="mt-10">
                            <ol className="relative border-l border-white">
                                <li className="mb-10 ml-6">
                                    <span className="absolute flex items-center justify-center w-8 h-8 bg-[#5B1FAD] rounded-full -left-4 ring-4 ring-white"></span>
                                    <h3 className="text-xl font-semibold text-gray-50">Inception</h3>
                                    <p className="mt-2 text-gray-50">
                                        Our journey began in 2005 when a group of visionaries set out to redefine the industry with innovative solutions.
                                    </p>
                                </li>
                                <li className="mb-10 ml-6">
                                    <span className="absolute flex items-center justify-center w-8 h-8 bg-[#5B1FAD] rounded-full -left-4 ring-4 ring-white"></span>
                                    <h3 className="text-xl font-semibold text-gray-50">Expansion</h3>
                                    <p className="mt-2 text-gray-50">
                                        In 2010, we expanded our operations, establishing offices in key markets around the globe to better serve our clients.
                                    </p>
                                </li>
                                <li className="mb-10 ml-6">
                                    <span className="absolute flex items-center justify-center w-8 h-8 bg-[#5B1FAD] rounded-full -left-4 ring-4 ring-white"></span>
                                    <h3 className="text-xl font-semibold text-gray-50">Innovation</h3>
                                    <p className="mt-2 text-gray-50">
                                        Embracing technology and innovation, we launched our groundbreaking platform in 2015, revolutionizing our industry.
                                    </p>
                                </li>
                                <li className="ml-6">
                                    <span className="absolute flex items-center justify-center w-8 h-8 bg-[#5B1FAD] rounded-full -left-4 ring-4 ring-white"></span>
                                    <h3 className="text-xl font-semibold text-gray-50">Today</h3>
                                    <p className="mt-2 text-gray-50">
                                        Today, we continue to push boundaries, delivering unparalleled results and setting new standards in our field.
                                    </p>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                {/* ======================================================= */}
                {/* End Timeline / History Section */}
                {/* ======================================================= */}

                {/* ======================================================= */}
                {/* Core Values Section */}
                {/* ======================================================= */}
                <div className="py-16 bg-gray-100">
                    <div className="max-w-6xl mx-auto px-6">
                        <h2 className="text-3xl md:text-4xl font-bold text-center text-[#5B1FAD]">Our Core Values</h2>
                        <div className="mt-10 grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div className="p-8 bg-white rounded-lg shadow hover:shadow-lg transition duration-300 text-center">
                                <h3 className="text-xl font-semibold text-[#5B1FAD]">Integrity</h3>
                                <p className="mt-4 text-gray-600">
                                    We conduct our business with the highest standards of ethics and transparency.
                                </p>
                            </div>
                            <div className="p-8 bg-white rounded-lg shadow hover:shadow-lg transition duration-300 text-center">
                                <h3 className="text-xl font-semibold text-[#5B1FAD]">Innovation</h3>
                                <p className="mt-4 text-gray-600">
                                    Creativity and forward-thinking drive our approach to solving complex challenges.
                                </p>
                            </div>
                            <div className="p-8 bg-white rounded-lg shadow hover:shadow-lg transition duration-300 text-center">
                                <h3 className="text-xl font-semibold text-[#5B1FAD]">Excellence</h3>
                                <p className="mt-4 text-gray-600">
                                    We strive for excellence in every project, ensuring outstanding quality and performance.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                {/* ======================================================= */}
                {/* End Core Values Section */}
                {/* ======================================================= */}



                {/* ======================================================= */}
                {/* Call to Action Section */}
                {/* ======================================================= */}
                <div className="py-16 ">
                    <div className="max-w-6xl mx-auto px-6 text-center">
                        <h2 className="text-4xl md:text-5xl font-bold text-white">Join Our Journey</h2>
                        <p className="mt-6 text-lg text-white max-w-2xl mx-auto">
                            Learn more about our vision, our values, and the talented team driving our success.
                        </p>
                        <div className="mt-10">
                            <a
                                href="/contact"
                                className="px-8 py-3 bg-white text-[#5B1FAD] rounded-md font-semibold hover:bg-gray-100 transition duration-300"
                            >
                                Get In Touch
                            </a>
                        </div>
                    </div>
                </div>
                {/* ======================================================= */}
                {/* End Call to Action Section */}
                {/* ======================================================= */}

            </section>
        </NavBar>
    );
}
