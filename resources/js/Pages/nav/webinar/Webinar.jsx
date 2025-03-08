import React, { useEffect, useRef } from "react";
import gsap from "gsap";
import NavBar from "@/Layouts/NavBar.jsx";

const WebinarPage = () => {
    // Create refs for sections to animate
    const heroRef = useRef(null);
    const expectRef = useRef(null);
    const speakersRef = useRef(null);

    useEffect(() => {
        // Create a GSAP timeline with staggered animations
        const tl = gsap.timeline({ defaults: { duration: 1, ease: "power2.out" } });
        tl.from(heroRef.current, { opacity: 0, y: 50 })
            .from(expectRef.current, { opacity: 0, y: 50 }, "+=0.3")
            .from(speakersRef.current, { opacity: 0, y: 50 }, "+=0.3");
    }, []);

    return (
        <NavBar>
            <div className="min-h-screen">
                <main>
                    {/* Hero Section */}
                    <section
                        ref={heroRef}
                        className="relative bg-cover bg-center h-screen"
                        style={{ backgroundImage: "url('/images/webinar-bg.jpg')" }}
                    >
                        <div className="relative z-10 flex flex-col items-center justify-center h-full text-center px-4">
                            <h1 className="text-4xl md:text-6xl font-bold text-gray-50 mb-4">
                                Join the NoeCapital Webinar
                            </h1>
                            <p className="text-lg md:text-2xl text-gray-100 max-w-2xl mb-8">
                                Learn the latest trends in capital innovation and discover proven
                                strategies to grow your business from industry experts.
                            </p>
                            <form className="w-full max-w-md mx-auto">
                                <div className="flex flex-col sm:flex-row gap-4">
                                    <input
                                        type="email"
                                        placeholder="Enter your email"
                                        className="w-full px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    />
                                    <button
                                        type="submit"
                                        className="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700"
                                    >
                                        Register Now
                                    </button>
                                </div>
                            </form>
                        </div>
                    </section>

                    {/* What to Expect Section */}
                    <section ref={expectRef} className="py-16">
                        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            <h2 className="text-3xl font-bold text-gray-50 text-center mb-8">
                                What to Expect
                            </h2>
                            <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
                                <div className="p-6 border border-gray-200 rounded-lg">
                                    <h3 className="text-xl font-semibold text-gray-200 mb-2">
                                        Expert Speakers
                                    </h3>
                                    <p className="text-gray-100">
                                        Hear from industry leaders about the future of capital and
                                        innovation.
                                    </p>
                                </div>
                                <div className="p-6 border border-gray-200 rounded-lg">
                                    <h3 className="text-xl font-semibold text-gray-200 mb-2">
                                        Interactive Q&amp;A
                                    </h3>
                                    <p className="text-gray-100">
                                        Engage directly with our experts during a live Q&amp;A session.
                                    </p>
                                </div>
                                <div className="p-6 border border-gray-200 rounded-lg">
                                    <h3 className="text-xl font-semibold text-gray-200 mb-2">
                                        Actionable Insights
                                    </h3>
                                    <p className="text-gray-100">
                                        Get practical tips and strategies you can implement immediately.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </section>

                    {/* Speakers Section - Coming Soon */}
                    <section ref={speakersRef} className="py-16">
                        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                            <h2 className="text-3xl font-bold text-gray-50 mb-8">
                                Meet the Speakers
                            </h2>
                            <p className="text-xl text-gray-200">Coming Soon</p>
                        </div>
                    </section>
                </main>
            </div>
        </NavBar>
    );
};

export default WebinarPage;
