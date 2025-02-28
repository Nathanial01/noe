import ApplicationLogo from "@/Components/ApplicationLogo";
import NavLink from "@/Components/NavLink";
import { usePage } from "@inertiajs/react";
import { useState } from "react";
import DarkModeToggle from "@/Components/DarkModeToggle";
import Footer from "@/Components/Footer";
import Background from "@/Components/Background.jsx";

export default function AuthenticatedLayout({ header, children }) {
    const { auth } = usePage().props;
    const user = auth.user;
    const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);

    const toggleMobileMenu = () => setIsMobileMenuOpen((prev) => !prev);

    // Navigation links for the required pages.
    const navLinks = [
        { href: "/", label: "Home" },
        { href: "/private-equity", label: "Private Equity" },
        { href: "/real-estate", label: "Real Estate" },
        { href: "/about", label: "About Us" },
        { href: "/contact", label: "Contact" },
    ];

    return (
        <div className="relative min-h-screen">
            {/* Background Image */}
            <div className="fixed inset-0 -z-50">
                <Background backgrounds={["/img/landing/global-bg-one.png"]} />
            </div>

            {/* Overlay Effect */}
            <div className="fixed inset-0 bg-none backdrop-blur-2xl -z-40"></div>

            {/* Page Content */}
            <div className="relative z-10">
                {/* Sticky Navigation */}
                <nav className="sticky top-0 py-4 z-50 nav">
                    <div className="mx-auto flex justify-between items-center px-4 w-full">
                        {/* Logo wrapped in NavLink */}
                        <div className="flex items-center sm:ml-12">
                            <NavLink href="/">
                                <ApplicationLogo className="h-9 w-auto fill-current text-dark-mode" />
                            </NavLink>
                        </div>

                        {/* Mobile Menu Toggle */}
                        <div className="lg:hidden">
                            <button onClick={toggleMobileMenu} className="w-14 h-14 relative focus:outline-none bg-inherit rounded text-dark-mode-hovers">
                                <div className="block w-3 absolute left-6 top-1/2 transform -translate-x-1/2 -translate-y-1/2">
                                    <span className={`hamburger-menu-dark-mode ${isMobileMenuOpen ? "rotate-45" : "-translate-y-1.5"}`}></span>
                                    <span className={`hamburger-menu-dark-mode ${isMobileMenuOpen ? "opacity-0" : ""}`}></span>
                                    <span className={`hamburger-menu-dark-mode ${isMobileMenuOpen ? "-rotate-45" : "translate-y-1.5"}`}></span>
                                </div>
                            </button>
                        </div>

                        {/* Desktop Navigation */}
                        <div className="hidden sm:flex flex-1 items-center justify-center sm:items-stretch sm:justify-end">
                            <nav className="flex space-x-4">
                                {navLinks.map((link) => (
                                    <NavLink key={link.href} href={link.href} className="text-dark-mode-hovers hover:underline">
                                        {link.label}
                                    </NavLink>
                                ))}
                            </nav>
                        </div>

                        {/* User & Dark Mode (Desktop) */}
                        <div className="hidden lg:flex items-center space-x-4">
                            {user ? (
                                <form method="POST" action={route("logout")}>
                                    <button type="submit" className="logout-link-dark-mode-hovers">Uitloggen</button>
                                </form>
                            ) : (
                                <>
                                    <NavLink href="/login" className="logout-link-dark-mode-hovers">Inloggen</NavLink>
                                    <NavLink href="/register" className="register-link-dark-hovers">Account aanmaken</NavLink>
                                </>
                            )}
                            <DarkModeToggle />
                        </div>
                    </div>
                </nav>

                {/* Header (if provided) */}
                {header && (
                    <header className="bg-white shadow dark:bg-gray-800">
                        <div className="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">{header}</div>
                    </header>
                )}

                {/* Main Content */}
                <main className="container mx-auto p-6">{children}</main>

                {/* Footer */}
                <Footer />
            </div>
        </div>
    );
}
