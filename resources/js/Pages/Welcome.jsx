import React, { Suspense, useEffect, useRef } from "react";
import { lazy } from "react";
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { Head } from "@inertiajs/react";

// Import the updated NavBar component (which uses Headless UI)
import NavBar from "@/Layouts/NavBar";
import ChatBot from "../Pages/ChatBot/ChatBot";
import Header from "../Components/Header";
import Background from "../Components/Background";
import HeroSection from "../Components/HeroSection.jsx";
import NotificationBar from "@/Components/NotificationBar.jsx";

// Lazy-load components with webpack prefetch hints
const Featuresections = lazy(() =>
    import(/* webpackPrefetch: true */ "@/Components/Featuresections")
);
const FeatureAboutUs = lazy(() =>
    import(/* webpackPrefetch: true */ "@/Components/FeatureAboutUs")
);
const Testimonials = lazy(() =>
    import(/* webpackPrefetch: true */ "@/Components/Testimonials")
);

gsap.registerPlugin(ScrollTrigger);

export default function Dashboard({ gigCount = 0, invitationCount = 0, user }) {
    // Create refs for animation triggers
    const welcomeRef = useRef(null);
    const featureSectionsRef = useRef(null);
    const aboutUsRef = useRef(null);
    const testimonialsRef = useRef(null);

    useEffect(() => {
        const animateElement = (ref) => {
            if (ref.current) {
                gsap.fromTo(
                    ref.current,
                    { opacity: 0, y: 20 },
                    {
                        opacity: 1,
                        y: 0,
                        duration: 1.5,
                        ease: "power3.out",
                        scrollTrigger: {
                            trigger: ref.current,
                            start: "top 80%",
                            toggleActions: "play none none none",
                        },
                    }
                );
            }
        };

        animateElement(welcomeRef);
        animateElement(featureSectionsRef);
        animateElement(aboutUsRef);
        animateElement(testimonialsRef);
    }, []);

    return (
        <>
            <Head>
                <title>Dashboard - CyrBot</title>
                <meta name="description" content="noe captal." />
            </Head>

            {/* NavBar placed above backgrounds */}
            <div className="relative z-50">
                {/* Fixed NotificationBar */}
                <div className="fixed top-0 inset-x-0 z-50">
                    <NotificationBar />
                </div>

                {/* NavBar with a top offset to sit beneath the NotificationBar */}
                <NavBar offsetClass="top-10" >



                    {/* Background layers (placed behind everything) */}
                    <div className="fixed inset-0 -z-20">
                        <Background
                            className="w-full h-full opacity-50"
                            backgrounds={["/img/landing/global-bg-one.png"]}
                        />
                        <div className="fixed inset-0 bg-[#6B00FE]/10 dark:bg-black/20 backdrop-blur-sm" />
                    </div>

                    {/* Dashboard Content */}
                    <div className="relative container mx-auto z-10 px-4 sm:px-12 lg:px-24">
                {/* Mobile Hero Section */}
                <section
                    ref={welcomeRef}
                    className="grid grid-flow-col-2 grid-rows-1 gap-4 sm:hidden"
                >
                    <div className="gap-4 mt-44">
                        <Header />
                    </div>
                    <div className="flex justify-center items-center">      <button className="hero__down" aria-label="scroll down">
                        <img
                            src="/img/landing/scroll.svg"
                            alt="Scroll Down"
                            className="h-10 mt-10 animate-bounce"
                        />
                    </button>
                    </div>
                </section>

                {/* Desktop Hero Section */}
                <section
                    ref={welcomeRef}
                    className="hidden sm:flex items-center w-full h-screen scale-90"
                >
                    {/* Left Side: Hero Section */}
                    <div className="w-5/12 sm:scale-[30%] sm:lg:mr-40 lg:scale-100 lg:mt-44 lg:mr-40">
                        <HeroSection />
                    </div>
                    {/* Spacer */}
                    <div className="flex-grow" />
                    {/* Right Side: Header */}
                    <div className="w-5/12 sm:scale-50 lg:scale-100 mb-20">
                        <Header />
                    </div>
                    <div className="absolute hidden sm:flex justify-center items-center bottom-0 left-[650px] ">
                        <img
                            src="/img/landing/scroll.svg"
                            alt="Scroll Down"
                            className="h-10 mt-10 animate-bounce"
                        />
                    </div>
                </section>

                {/* Feature Sections */}
                <section
                    ref={featureSectionsRef}
                    className="relative w-full min-h-screen overflow-hidden"
                >
                    <Suspense fallback={<div>Loading Featuresections...</div>}>
                        <Featuresections />
                    </Suspense>
                </section>

                {/* Main Content */}
                <div className="relative bg-transparent">
                    <main className="relative container mx-auto z-10 px-4 sm:px-12 lg:px-24">
                        {/* Feature About Us Section */}
                        <div ref={aboutUsRef}>
                            <Suspense fallback={<div>Loading Feature About Us...</div>}>
                                <FeatureAboutUs />
                            </Suspense>
                        </div>

                        {/* Testimonials Section */}
                        {/*<div ref={testimonialsRef}>*/}
                        {/*    <Suspense fallback={<div>Loading Testimonials...</div>}>*/}
                        {/*        <Testimonials />*/}
                        {/*    </Suspense>*/}
                        {/*</div>*/}

                        {/* ChatBot Section */}
                        <div className="mt-0">
                            <ChatBot />
                        </div>
                    </main>
                </div>
            </div>
                </NavBar>
            </div>
        </>
    );
}
