import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/react';
import { MagnifyingGlassIcon } from '@heroicons/react/20/solid';
import { Bars3Icon, BellIcon, XMarkIcon } from '@heroicons/react/24/outline';
import ApplicationLogo from "@/Components/ApplicationLogo";
import NavLink from "@/Components/NavLink";
import { usePage } from "@inertiajs/react";
import DarkModeToggle from "@/Components/DarkModeToggle";
import Footer from "@/Components/Footer";
import Background from "@/Components/Background.jsx";

// Navigation links array.
const navLinks = [
    { href: "/", label: "Home" },
    { href: "/private-equity", label: "Private Equity" },
    { href: "/real-estate", label: "Real Estate" },
    { href: "/about", label: "About Us" },
    { href: "/contact", label: "Contact" },
];

// Mobile user menu component.
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

// Desktop user dropdownmenu component.
const UserLinks = ({ user }) => {
    return (
        <Menu as="div" className="relative ml-4 shrink-0">
            <div>
                <MenuButton className="flex rounded-full bg-gray-800 text-sm focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                    <span className="sr-only">Open user menu</span>
                    {user ? (
                        <img
                            src={user.avatar || "../../../../../public/img/SVGS/profile.svg"}
                            alt="User Avatar"
                            className="h-8 w-8 rounded-full"
                        />
                    ) : (
                        <span className="inline-block h-8 w-8 rounded-full bg-gray-500"></span>
                    )}
                </MenuButton>
            </div>
            <MenuItems className="absolute left-0 z-50 mt-2 w-48 origin-top-right rounded-md bg-white dark:bg-gray-950 py-1 shadow-lg ring-1 ring-yell/5">
                {user ? (
                    <>
                        <MenuItem>
                            {({ active }) => (
                                <a
                                    href="/profile"
                                    className={`${active ? "bg-gray-100" : ""} block px-4 py-2 text-sm text-gray-700`}
                                >
                                    Your Profile
                                </a>
                            )}
                        </MenuItem>
                        <MenuItem>
                            {({ active }) => (
                                <a
                                    href="/settings"
                                    className={`${active ? "bg-gray-100" : ""} block px-4 py-2 text-sm text-gray-700`}
                                >
                                    Settings
                                </a>
                            )}
                        </MenuItem>
                        <MenuItem>
                            {({ active }) => (
                                <form method="POST" action={route("logout")}>
                                    <button
                                        type="submit"
                                        className={`${active ? "bg-gray-100" : ""} block w-full text-left px-4 py-2 text-sm text-gray-700`}
                                    >
                                        Sign out
                                    </button>
                                </form>
                            )}
                        </MenuItem>
                    </>
                ) : (
                    <>
                        <MenuItem>
                            {({ active }) => (
                                <NavLink
                                    href="/login"
                                    className={`${active ? "bg-gray-100" : "bg-gray-100"} block px-4 py-2 text-sm text-gray-700`}
                                >
                                    Login
                                </NavLink>
                            )}
                        </MenuItem>
                        <MenuItem>
                            {({ active }) => (
                                <NavLink
                                    href="/register"
                                    className={`${active ? "bg-gray-100" : ""} block px-4 py-2 text-sm text-gray-700`}
                                >
                                    Register
                                </NavLink>
                            )}
                        </MenuItem>
                    </>
                )}
                <div className="flex justify-center align-middle">
                    <DarkModeToggle />
                </div>
            </MenuItems>
        </Menu>
    );
};

export default function NavBar({ header, children }) {
    const { auth } = usePage().props;
    const user = auth.user;

    return (
        <div className="relative min-h-screen">
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
                        <div className="mx-auto max-w-7xl px-2 sm:px-4 lg:px-8">
                            <div className="relative flex h-16 items-center justify-between">
                                {/* Left: Logo & Desktop Nav Links */}
                                <div className="flex items-center px-2 lg:px-0">
                                    <NavLink href="/">
                                        <ApplicationLogo className="h-8 w-auto" />
                                    </NavLink>
                                    <div className="hidden lg:ml-6 lg:block">
                                        <div className="flex space-x-4">
                                            {navLinks.map((link) => (
                                                <NavLink
                                                    key={link.href}
                                                    href={link.href}
                                                    className="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white"
                                                >
                                                    {link.label}
                                                </NavLink>
                                            ))}
                                        </div>
                                    </div>
                                </div>

                                {/* Center: Search Bar */}
                                <div className="flex flex-1 justify-center px-2 lg:ml-6 lg:justify-end">
                                    <div className="grid w-full max-w-lg grid-cols-1 lg:max-w-xs">
                                        <input
                                            name="search"
                                            type="search"
                                            placeholder="Search"
                                            aria-label="Search"
                                            className="col-start-1 row-start-1 block w-full rounded-md bg-none backdrop-blur-3xl py-1.5 pr-3 pl-10 text-base text-white placeholder:text-gray-400 focus:bg-white focus:text-gray-900 focus:placeholder:text-gray-400 sm:text-sm"
                                        />
                                        <MagnifyingGlassIcon
                                            aria-hidden="true"
                                            className="pointer-events-none col-start-1 row-start-1 ml-3 h-5 w-5 self-center text-gray-400"
                                        />
                                    </div>
                                </div>

                                {/* Right: Notification Button, Dark Mode Toggle & User Menu (Desktop) */}
                                <div className="hidden lg:ml-4 lg:flex lg:items-center">
                                    {/*<button*/}
                                    {/*    type="button"*/}
                                    {/*    className="rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"*/}
                                    {/*>*/}
                                    {/*    <span className="sr-only">View notifications</span>*/}
                                    {/*    <BellIcon className="h-6 w-6" aria-hidden="true" />*/}
                                    {/*</button>*/}
                                    <UserLinks user={user} />
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
                            <div className="flex justify-center align-middle ">
                                <DarkModeToggle />
                            </div>
                        </Disclosure.Panel>

                    </>
                )}

            </Disclosure>

            {/* Optional Header */}
            {header && (
                <header className="bg-white shadow dark:bg-gray-800">
                    <div className="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">{header}</div>
                </header>
            )}

            {/* Main Content */}
            <main className="container mx-auto z-50">{children}</main>

            {/* Footer */}
            <Footer />
        </div>
    );
}
