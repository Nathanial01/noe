import React, { Suspense, useEffect, useRef, useState } from "react";
import { lazy } from "react";
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import NavBar from "@/Layouts/NavBar";
import { Head } from "@inertiajs/react";
import ChatBot from "../Pages/ChatBot/ChatBot";
import HeroSection from "../Components/HeroSection";
import Header from "../Components/Header";
import Background from "../Components/Background";

// Lazy-load components for performance
const Featuresections = lazy(() => import("@/Components/Featuresections"));
const FeatureAboutUs = lazy(() => import("@/Components/FeatureAboutUs"));
const Testimonials = lazy(() => import("@/Components/Testimonials"));

gsap.registerPlugin(ScrollTrigger);

export default function Dashboard({ gigCount = 0, invitationCount = 0, user }) {
  // References for animations
  const welcomeRef = useRef(null);
  const featureSectionsRef = useRef(null);
  const aboutUsRef = useRef(null);
  const testimonialsRef = useRef(null);

  // State tracking for sequential animations
  const [isWelcomeRefLoaded, setIsWelcomeRefLoaded] = useState(false);
  const [isFeatureSectionsLoaded, setIsFeatureSectionsLoaded] = useState(false);
  const [isAboutUsLoaded, setIsAboutUsLoaded] = useState(false);

  useEffect(() => {
    const animateElement = (ref, onComplete) => {
      if (ref.current) {
        gsap.fromTo(
          ref.current,
          { opacity: 0, y: 0 },
          {
            opacity: 1,
            y: 0,
            duration: 3,
            ease: "power3.out",
            scrollTrigger: {
              trigger: ref.current,
              start: "top 80%",
              end: "bottom 50%",
              toggleActions: "play none none none",
            },
            onComplete,
          }
        );
      }
    };

    // Animate Welcome Section
    animateElement(welcomeRef, () => setIsWelcomeRefLoaded(true));

    // Animate Featuresections after Welcome animation completes
    if (isWelcomeRefLoaded)
      animateElement(featureSectionsRef, () => setIsFeatureSectionsLoaded(true));

    // Animate About Us after Featuresections animation completes
    if (isFeatureSectionsLoaded)
      animateElement(aboutUsRef, () => setIsAboutUsLoaded(true));

    // Animate Testimonials after About Us animation completes
    if (isAboutUsLoaded) animateElement(testimonialsRef);
  }, [isWelcomeRefLoaded, isFeatureSectionsLoaded, isAboutUsLoaded]);

  return (
    <>
      <Head>
        <title>Dashboard - CyrBot</title>
        <meta name="description" content="Your Personal CyrBot." />
      </Head>
      <NavBar>
        {/* Global Background */}
        <Background
          className="fixed"
          backgrounds={[
            "/img/landing/global-bg-one.png",
          ]}
        />

        {/* Top Section 1 - Welcome */}
        <section
          ref={welcomeRef}
          className="relative w-full min-h-screen  flex flex-col sm:flex-row-reverse justify-between items-center px-4 sm:px-12 lg:px-24 gap-x-4 sm:gap-x-8 lg:gap-x-16"
        >
          {/* Header Section */}
          <div className="w-full sm:w-1/2 flex justify-end">
            <Header />
          </div>
      
        </section>

{/* Top Section 2 - Featuresections with its own background */}

<section
  ref={featureSectionsRef}
  className="relative w-full min-h-screen overflow-hidden"
>
  {/* Gradient Background Container */}
 
  <Suspense fallback={<div>Loading Featuresections...</div>}>
    <Featuresections />
  </Suspense>
</section>

        {/* Main Content */}
        <div className="relative bg-transparent">
          <main className="relative container mx-auto z-10 px-4 sm:px-12 lg:px-24">
            {/* FeatureAboutUs Component */}
            {isFeatureSectionsLoaded && (
              <div ref={aboutUsRef}>
                <Suspense fallback={<div>Loading Feature About Us...</div>}>
                  <FeatureAboutUs />
                </Suspense>
              </div>
            )}

            {/* Testimonials Component */}
            {isAboutUsLoaded && (
              <div ref={testimonialsRef}>
                <Suspense fallback={<div>Loading Testimonials...</div>}>
                  <Testimonials />
                </Suspense>
              </div>
            )}

            {/* Chatbot Section */}
            <div className="mt-0">
              <ChatBot />
            </div>
          </main>
        </div>
      </NavBar>
    </>
  );
}