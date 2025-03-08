/*
 * NavBar.jsx
 *
 * This component renders a responsive navigation bar that includes:
 * - A background image with an overlay effect.
 * - A fixed navigation menu that adapts for desktop and mobile views.
 * - A search bar, info buttons (Webinar, Masterclass, Agenda), and user-related links.
 * - A dark mode toggle and a footer.
 */

import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/react';
import { Bars3Icon, XMarkIcon } from '@heroicons/react/24/outline';
import ApplicationLogo from "@/Components/ApplicationLogo";
import NavLink from "@/Components/NavLink";
import { usePage } from "@inertiajs/react";
import DarkModeToggle from "@/Components/DarkModeToggle";
import Footer from "@/Components/Footer";
import Background from "@/Components/Background.jsx";
import SearchBar from "@/Components/SearchBar.jsx";
import { FaVideo, FaChalkboardTeacher, FaCalendarAlt } from 'react-icons/fa';
import {useState} from "react";

// Navigation links array
const navLinks = [
    { href: "/", label: "Home" },
    { href: "/private-equity", label: "Private Equity" },
    { href: "/real-estate", label: "Real Estate" },
    { href: "/about", label: "About Us" },
    { href: "/contact", label: "Contact" },
];

/**
 * Info Component
 * Renders buttons for Webinar, Masterclass, and Agenda.
 */
const Info = () => {
    return (
        <div className="flex space-x-4">
            {/* Webinar Button */}
            <a href="/webinar" className="group relative flex items-center text-[#9c9c9c] hover:text-white transition">
                <FaVideo className="text-lg" />
                <span className="absolute left-1/2 -translate-x-1/2 bottom-full mb-2 opacity-0 group-hover:opacity-100 text-white text-sm transition-opacity duration-200 whitespace-nowrap">
                    Webinar
                </span>
            </a>

            {/* Masterclass Button */}
            <a href="/masterclass" className="group relative flex items-center text-[#9c9c9c] hover:text-white transition">
                <FaChalkboardTeacher className="text-lg" />
                <span className="absolute left-1/2 -translate-x-1/2 bottom-full mb-2 opacity-0 group-hover:opacity-100 text-white text-sm transition-opacity duration-200 whitespace-nowrap">
                    Masterclass
                </span>
            </a>

            {/* Agenda Button */}
            <a href="/agendaevent" className="group relative flex items-center text-[#9c9c9c] hover:text-white transition">
                <FaCalendarAlt className="text-lg" />
                <span className="absolute left-1/2 -translate-x-1/2 bottom-full mb-2 opacity-0 group-hover:opacity-100 text-white text-sm transition-opacity duration-200 whitespace-nowrap">
                   Events
                </span>
            </a>
        </div>
    );
};
/**
 * StripedDivider Component
 * Renders a vertical divider with a gradient effect.
 */
const StripedDivider = () => {
    return <div className="w-px h-6 m-2 bg-gradient-to-b from-transparent via-white/50 to-transparent"></div>;
};

/**
 * MobileUser Component
 * Renders mobile user actions.
 * - If a user is logged in, display a logout button.
 * - Otherwise, display login and register links.
 */
const MobileUser = ({ user }) => {
    return user ? (
        <form method="POST" action={route("logout")}>
            <button type="submit" className="logout-link-dark-mode-hovers">
                Uitloggen
            </button>
        </form>
    ) : (
        <>

            <NavLink
                href="/login"
                className="rounded-md bg-white/10 px-3.5 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-white/20"
            >
                <span>Inloggen</span>
            </NavLink>
            <NavLink
                href="/register"
                className="rounded-md bg-white/10 px-3.5 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-white/20"
            >
                <span>Registreren</span>
            </NavLink>
        </>
    );
};

/**
 * SearchBar Component
 * Renders a search input with a keyboard shortcut indicator.
 */



/**
 * UserLinks Component (Desktop)
 * Renders user-related links based on authentication status.
 */
export const UserLinks = ({user}) => {
    // Instead of handling dashboard redirection here,
    // we delegate that decision to the backend.
    const dashboardUrl = '/dashboard';

    return (
        <div className="flex items-center gap-4 p-4">
            {user ? (
                <>
                    <StripedDivider/>
                    <a
                        href={dashboardUrl}
                        className="flex items-center hover:scale-105 font-medium transition"
                    >
                        <svg
                            width="20"
                            height="20"
                            viewBox="0 0 0.6 0.6"
                            xmlns="http://www.w3.org/2000/svg"
                            className="icon flat-color mr-2"
                        >
                            <defs>
                                <linearGradient
                                    id="paint0_linear_90_214"
                                    x1="0.3"
                                    y1="0"
                                    x2="0.3"
                                    y2="0.6"
                                    gradientUnits="userSpaceOnUse"
                                >
                                    <stop stopColor="#F2BE0E" />
                                    <stop offset="1" stopColor="#581CAF" />
                                </linearGradient>
                            </defs>
                            <path
                                d="M.55.1v.075a.05.05 0 0 1-.05.05H.375a.05.05 0 0 1-.05-.05V.1a.05.05 0 0 1 .05-.05H.5A.05.05 0 0 1 .55.1M.225.375H.1a.05.05 0 0 0-.05.05V.5A.05.05 0 0 0 .1.55h.125A.05.05 0 0 0 .275.5V.425a.05.05 0 0 0-.05-.05"
                                fill="url(#paint0_linear_90_214)"
                            />
                            <path
                                d="M.275.1v.175a.05.05 0 0 1-.05.05H.1a.05.05 0 0 1-.05-.05V.1A.05.05 0 0 1 .1.05h.125a.05.05 0 0 1 .05.05M.5.275H.375a.05.05 0 0 0-.05.05V.5a.05.05 0 0 0 .05.05H.5A.05.05 0 0 0 .55.5V.325A.05.05 0 0 0 .5.275"
                                fill="url(#paint0_linear_90_214)"
                            />
                        </svg>
                    </a>
                    <NavLink
                        method="post"
                        href={route('logout')}
                        className="text-gray-50 hover:text-gray-700 font-medium"
                        onClick={() => {
                            // Add your sign-out logic here.
                        }}
                    >
                        Sign Out
                    </NavLink>
                </>
            ) : (
                <>
                    <StripedDivider />
                    <NavLink
                        rel="nofollow"
                        href="/login?referrer=%2F"
                        className="text-gray-50 hover:text-gray-700 font-medium"
                    >
                        Login
                    </NavLink>
                    <StripedDivider />
                    <NavLink
                        rel="nofollow"
                        href="/register"
                        className="text-gray-50 hover:text-gray-700 font-medium"
                    >
                        Register
                    </NavLink>
                </>
            )}
        </div>
    );
};

/**
 * NavBar Component
 * Main navigation bar component.
 */
export default function NavBar({ header, children }) {
    const { auth } = usePage().props;
    const user = auth.user;

    return (
        <div className="relative min-h-screen ">
            {/* Background Image */}
            <div className="fixed inset-0 -z-50">
                <Background backgrounds={["/img/landing/global-bg-one.png"]} />
            </div>

            {/* Overlay Effect */}
            <div className="fixed inset-0 bg-none backdrop-blur-2xl -z-40"></div>

            {/* Fixed Navigation Bar */}
            <Disclosure as="nav" className="fixed top-0 inset-x-0 z-50 bg-none backdrop-blur-2xl">
                {({ open }) => (
                    <>
                        <div className="mx-auto  px-2 sm:px-4 lg:px-8">
                            <div className="relative flex h-16 items-center justify-between">
                                {/* Left Section: Logo & Desktop Navigation Links */}
                                <div className="flex items-center px-2 lg:px-0">
                                    <NavLink href="/">
                                        <ApplicationLogo className="h-8 w-auto" />
                                    </NavLink>
                                    <div className="hidden lg:ml-6 lg:block">
                                        <div className="flex space-x-4 flex-nowrap overflow-hidden">
                                            {navLinks.map((link) => (
                                                <NavLink
                                                    key={link.href}
                                                    href={link.href}
                                                    className="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white whitespace-nowrap block"
                                                >
                                                    {link.label}
                                                </NavLink>
                                            ))}
                                        </div>
                                    </div>
                                </div>

                                {/* Center Section: Search Bar */}
                                <div className="flex items-center gap-2">

                                    <SearchBar />
                                    <div className="hidden max-sm:hidden lg:block">   <StripedDivider  /></div>

                                    <div className="hidden lg:flex ">
                                    <Info />
                                    <StripedDivider/>
                                    </div>
                                </div>
                                {/* Right Section: Desktop User Menu & Dark Mode Toggle */}
                                <div className="hidden lg:ml-4 lg:flex lg:items-center lg:space-x-4 lg:overflow-hidden lg:flex-nowrap">
                                    {/*
      Uncomment the following block if notifications are needed.
      <button
          type="button"
          className="rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
      >
          <span className="sr-only">View notifications</span>
          <BellIcon className="h-6 w-6" aria-hidden="true" />
      </button>
    */}
                                    <UserLinks user={user} className="whitespace-nowrap flex-shrink-0" />
                                    <StripedDivider className="whitespace-nowrap flex-shrink-0" />
                                    <div className="flex justify-center items-center flex-nowrap">
                                        <DarkModeToggle className="whitespace-nowrap flex-shrink-0" />
                                    </div>
                                </div>

                                {/* Mobile Menu Button */}
                                <div className="flex lg:hidden">
                                    <DisclosureButton className="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none">
                                        <span className="sr-only">Open main menu</span>
                                        {open ? (
                                            <XMarkIcon className="block h-6 w-6" aria-hidden="true" />
                                        ) : (
                                            <Bars3Icon className="block h-6 w-6" aria-hidden="true" />
                                        )}
                                    </DisclosureButton>
                                </div>
                            </div>
                        </div>

                        {/* Mobile Menu Dropdown */}
                        <Disclosure.Panel className="lg:hidden">
                            <div className="relative overflow-hidden text-dark-mode-reverse p-8">
                                <div className="flex flex-col space-y-2">
                                    {navLinks.map((link) => (
                                        <NavLink
                                            key={link.href}
                                            href={link.href}
                                            className="flex justify-between items-center text-dark-mode-hovers"
                                        >
                                            {link.label}
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                className="h-5 w-5 text-dark-mode"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                strokeWidth="2"
                                            >
                                                <path
                                                    strokeLinecap="round"
                                                    strokeLinejoin="round"
                                                    d="M9 5l7 7-7 7"
                                                />
                                            </svg>
                                        </NavLink>
                                    ))}
                                    <MobileUser user={user} />
                                </div>
                            </div>
                           <div className="flex justify-center items-center p-1">
                                <Info />
                                <div  className="p-2" > <DarkModeToggle/></div>

                            </div>
                        </Disclosure.Panel>
                    </>
                )}
            </Disclosure>

            {/* Optional Header Section */}
            {header && (
                <header className="bg-white shadow dark:bg-gray-800">
                    <div className="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {header}
                    </div>
                </header>
            )}

            {/* Main Content */}
            <main className=" mx-auto z-50">
                {children}
            </main>

            {/* Footer */}
            <Footer />
        </div>
    );
}
