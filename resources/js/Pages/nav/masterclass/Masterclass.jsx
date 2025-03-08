import React, { useRef, useEffect } from "react";
import gsap from "gsap";
import NavBar from "@/Layouts/NavBar.jsx";

const MasterclassPage = () => {
    // Create refs for each section to animate
    const heroRef = useRef(null);
    const learnRef = useRef(null);
    const aboutRef = useRef(null);

    useEffect(() => {
        // GSAP timeline to animate sections with a stagger effect
        const tl = gsap.timeline({ defaults: { duration: 1, ease: "power2.out" } });
        tl.from(heroRef.current, { opacity: 0, y: 50 })
            .from(learnRef.current, { opacity: 0, y: 50 }, "+=0.3")
            .from(aboutRef.current, { opacity: 0, y: 50 }, "+=0.3");
    }, []);

    return (
        <NavBar>
            <div className="min-h-screen text-white">
                {/* Hero Section - plain background (no bg image or color) */}
                <section ref={heroRef} className="flex items-center justify-center h-screen">
                    <div className="text-center px-4">
                        <h1 className="text-4xl md:text-7xl font-bold mb-4 text-gray-50">
                            Unlock Your Potential
                        </h1>
                        <p className="text-lg md:text-2xl max-w-2xl mb-8 text-gray-100">
                            Join our exclusive masterclass and learn from world-renowned experts.
                        </p>
                        <button className="px-8 py-4 bg-indigo-600 hover:bg-indigo-700 rounded-full text-xl font-semibold">
                            Enroll Now
                        </button>
                    </div>
                </section>

                {/* What You'll Learn Section */}
                <section ref={learnRef} className="py-16">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <h2 className="text-3xl font-bold text-center mb-12 text-gray-50">
                            What You'll Learn
                        </h2>
                        <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div className="p-6 rounded-lg shadow-lg border border-gray-700">
                                <h3 className="text-2xl font-bold mb-2 text-gray-200">
                                    Innovative Strategies
                                </h3>
                                <p className="text-gray-300">
                                    Discover cutting-edge methods to stay ahead in your industry.
                                </p>
                            </div>
                            <div className="p-6 rounded-lg shadow-lg border border-gray-700">
                                <h3 className="text-2xl font-bold mb-2 text-gray-200">
                                    Real-World Applications
                                </h3>
                                <p className="text-gray-300">
                                    Learn how to apply theory to practice with actionable insights.
                                </p>
                            </div>
                            <div className="p-6 rounded-lg shadow-lg border border-gray-700">
                                <h3 className="text-2xl font-bold mb-2 text-gray-200">
                                    Personal Growth
                                </h3>
                                <p className="text-gray-300">
                                    Enhance your skills and unlock your potential with expert guidance.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                {/* About Section */}
                <section ref={aboutRef} className="py-16">
                    <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                        <h2 className="text-3xl font-bold mb-6 text-gray-50">
                            About This Masterclass
                        </h2>
                        <p className="text-lg text-gray-300 leading-relaxed">
                            Our masterclass is designed to empower you with the skills and knowledge you need to succeed in today's competitive landscape. Learn from the best and transform your career or business through innovative insights and practical strategies.
                        </p>
                    </div>
                </section>
            </div>
        </NavBar>
    );
};

export default MasterclassPage;
