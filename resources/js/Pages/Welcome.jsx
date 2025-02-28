import React, {Suspense, useEffect, useRef} from "react";
import {lazy} from "react";
import {gsap} from "gsap";
import {ScrollTrigger} from "gsap/ScrollTrigger";
import NavBar from "@/Layouts/NavBar";
import {Head} from "@inertiajs/react";
import ChatBot from "../Pages/ChatBot/ChatBot";
import Header from "../Components/Header";
import Background from "../Components/Background";
// Lazy-load components with prefetch magic comments
const Featuresections = lazy(() => import(/* webpackPrefetch: true */ "@/Components/Featuresections"));
const FeatureAboutUs = lazy(() => import(/* webpackPrefetch: true */ "@/Components/FeatureAboutUs"));
const Testimonials = lazy(() => import(/* webpackPrefetch: true */ "@/Components/Testimonials"));

gsap.registerPlugin(ScrollTrigger);

export default function Dashboard({gigCount = 0, invitationCount = 0, user}) {
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
                    {opacity: 0, y: 20},
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
                <meta name="description" content="Your Personal CyrBot."/>
            </Head>
            <NavBar>

                <Background
                    className="fixed inset-0 w-full h-full opacity-50 -z-10"
                    backgrounds={["/img/landing/global-bg-one.png"]}
                />
                <div className="fixed inset-0 bg-white/20 dark:bg-black/20 backdrop-blur-sm -z-5"></div>
                {/* Welcome Section */}
                <section
                    ref={welcomeRef}
                    className="relative w-full min-h-screen sm:flex-row-reverse justify-between items-center px-4 sm:px-12 lg:px-24 gap-x-4 sm:gap-x-8 lg:gap-x-16"
                >
                    <div className="w-full sm:w-1/2 flex justify-end">
                        <Header/>
                    </div>
                </section>

                {/* Featuresections */}
                <section
                    ref={featureSectionsRef}
                    className="relative w-full min-h-screen overflow-hidden"
                >
                    <Suspense fallback={<div>Loading Featuresections...</div>}>
                        <Featuresections/>
                    </Suspense>
                </section>

                {/* Main Content */}
                <div className="relative bg-transparent">
                    <main className="relative container mx-auto z-10 px-4 sm:px-12 lg:px-24">
                        {/* FeatureAboutUs Component */}
                        <div ref={aboutUsRef}>
                            <Suspense fallback={<div>Loading Feature About Us...</div>}>
                                <FeatureAboutUs/>
                            </Suspense>
                        </div>

                        {/* Testimonials Component */}
                        <div ref={testimonialsRef}>
                            <Suspense fallback={<div>Loading Testimonials...</div>}>
                                <Testimonials/>
                            </Suspense>
                        </div>

                        {/* ChatBot Section */}
                        <div className="mt-0">
                            <ChatBot/>
                        </div>
                    </main>
                </div>
            </NavBar>
        </>
    );
}
