import React, { Suspense, useEffect, useRef } from "react";
import { lazy } from "react";
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import NavBar from "@/Layouts/NavBar";
import { Head } from "@inertiajs/react";
import ChatBot from "../Pages/ChatBot/ChatBot";
import Header from "../Components/Header";
import Background from "../Components/Background";
import HeroSection from "../Components/HeroSection.jsx";
// Lazy-load components with prefetch magic comments
const Featuresections = lazy(() => import(/* webpackPrefetch: true */ "@/Components/Featuresections"));
const FeatureAboutUs = lazy(() => import(/* webpackPrefetch: true */ "@/Components/FeatureAboutUs"));
const Testimonials = lazy(() => import(/* webpackPrefetch: true */ "@/Components/Testimonials"));

gsap.registerPlugin(ScrollTrigger);

export default function Dashboard({ gigCount = 0, invitationCount = 0, user }) {
    // Refs for animations
    const welcomeRef = useRef(null);
    const featureSectionsRef = useRef(null);
    const aboutUsRef = useRef(null);
    const testimonialsRef = useRef(null);

    useEffect(() => {
        // Simplified animation function without sequential gating
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

        // Animate all sections
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
            <NavBar>
                <Background
                    className="fixed inset-0 w-full h-full opacity-50 -z-10"
                    backgrounds={["/img/landing/global-bg-one.png"]}
                />
                <div className="fixed inset-0 bg-[#6B00FE]/10 dark:bg-black/20 backdrop-blur-sm -z-5"></div>

                {/* Mobile Full-screen Welcome (Hero) Section */}
                <section
                    ref={welcomeRef}
                    className="grid grid-flow-col-2 grid-rows-1 gap-4 sm:hidden"
                >
                    <div ref={welcomeRef} className="gap-4">
                        <Header />
                    </div>
                    <div ref={welcomeRef} className="flex justify-center items-center">
                        <img
                            src="/img/landing/scroll.svg"
                            alt="Scroll Down"
                            className="h-10 mt-10 animate-bounce"
                        />
                    </div>
                </section>

                {/* Desktop Full-screen Welcome (Hero) Section */}
                <section
                    ref={welcomeRef}
                    className="hidden sm:flex items-center p-4 w-full h-screen scale-90"
                >
                    {/* Left Side: HeroSection */}
                    <div className="w-5/12 sm:scale-50 lg:scale-100 lg:mt-44 lg:mr-40 mt-96">
                        <HeroSection/>
                    </div>


                    {/* Spacer */}
                    <div className="flex-grow" />

                    {/* Right Side: Header */}
                    <div className="w-5/12  sm:scale-50 lg:scale-100 -mt-96">
                        <Header />
                    </div>
                </section>


                {/* Featuresections */}
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
                        {/* FeatureAboutUs Component */}
                        <div ref={aboutUsRef}>
                            <Suspense fallback={<div>Loading Feature About Us...</div>}>
                                <FeatureAboutUs />
                            </Suspense>
                        </div>

                        {/* Testimonials Component */}
                        <div ref={testimonialsRef}>
                            <Suspense fallback={<div>Loading Testimonials...</div>}>
                                <Testimonials />
                            </Suspense>
                        </div>

                        {/* ChatBot Section */}
                        <div className="mt-0">
                            <ChatBot />
                        </div>
                    </main>
                </div>
            </NavBar>
        </>
    );
}
