import React, { useState, useEffect, useCallback } from "react";
import axios from "axios";
import 'ldrs/ping'; // Ensure this library is installed and provides <l-ping>

const allowedUrls = [
    "http://localhost",
    "http://localhost:5173",
    "https://noecapital-24a1e658d2d0.herokuapp.com"
];

const API_BASE_URL = allowedUrls.includes(window.location.origin)
    ? window.location.origin
    : "https://noecapital-24a1e658d2d0.herokuapp.com";

const SearchBar = () => {
    const [query, setQuery] = useState("");
    const [results, setResults] = useState([]);
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState("");

    const placeholderText = "How can I help you?";

    useEffect(() => {
        axios
            .get(`${API_BASE_URL}/sanctum/csrf-cookie`, { withCredentials: true })
            .catch((err) => console.error("CSRF Token Error:", err));
    }, []);

    const fetchResults = useCallback(async () => {
        if (!query.trim()) {
            setResults([]);
            return;
        }
        setLoading(true);
        setError("");
        setResults([]);
        try {
            const response = await axios.post(
                `${API_BASE_URL}/api/search`,
                { query },
                { withCredentials: true, headers: { "Content-Type": "application/json" } }
            );
            setResults(response.data.results || []);
        } catch (err) {
            setError(err.response?.data?.error || "Search failed. Please try again.");
        } finally {
            setLoading(false);
        }
    }, [query]);

    useEffect(() => {
        const delayDebounce = setTimeout(() => {
            fetchResults();
        }, 500);
        return () => clearTimeout(delayDebounce);
    }, [query, fetchResults]);

    return (
        <div className="relative backdrop-blur-3xl px-4">
            <div className="p-5 overflow-hidden h-10 rounded-full flex items-center duration-300 bg-gray-100 dark:bg-gray-900 backdrop-blur-3xl">
                <div className="flex items-center justify-center mr-4">
                    {loading ? (
                        <div className="flex items-center justify-center">
                            <l-ping size="45" speed="2" color="#818cf8" />
                        </div>
                    ) : (
                        <svg
                            height="24"
                            width="24"
                            viewBox="0 0 24 24"
                            data-name="Layer 1"
                            id="Layer_1"
                            className="sparkle"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <defs>
                                <linearGradient id="indigoGradient" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%" stopColor="#5c6ac4" />
                                    <stop offset="100%" stopColor="#4c51bf" />
                                </linearGradient>
                            </defs>
                            <path
                                fill="url(#indigoGradient)"
                                d="M10,21.236,6.755,14.745.264,11.5,6.755,8.255,10,1.764l3.245,6.491L19.736,11.5l-6.491,3.245ZM18,21l1.5,3L21,21l3-1.5L21,18l-1.5-3L18,18l-3,1.5ZM19.333,4.667,20.5,7l1.167-2.333L24,3.5,21.667,2.333,20.5,0,19.333,2.333,17,3.5Z"
                            />
                        </svg>
                    )}
                </div>
                <input
                    type="text"
                    placeholder={placeholderText}
                    className="outline-none bg-transparent border-0 w-full font-normal px-4 focus:ring-0 text-gray-950 dark:text-gray-50"
                    value={query}
                    onChange={(e) => setQuery(e.target.value)}
                />

                <div className="w-px h-6 mx-2 bg-gradient-to-b from-transparent via-white/50 to-transparent"></div>
                <span className="hidden sm:block text-gray-950 dark:text-gray-50">⌘K</span>
            </div>

            {query.trim() && (
                <div className="absolute sm:top-16 left-1/2 transform -translate-x-1/2 w-full sm:w-[480px] bg-gray-900/10 backdrop-blur-md shadow-lg rounded-lg p-3 text-gray-950 dark:text-gray-50 mt-2">
                    {error && <p className="text-sm text-red-500">{error}</p>}
                    {!loading && !error && results.length === 0 && (
                        <p className="text-sm text-gray-500">
                            No results found. Please try another search term.
                        </p>
                    )}   {/* Close button appears when query is non-empty */}
                    {query && (
                        <button
                            onClick={() => setQuery("")}
                            className="mr-4 flex items-center justify-center w-6 h-6 rounded-full focus:outline-none"
                        >
                            <span className="text-red-500 dark:text-red-800 hover:scale-150 text-s font-bold">×</span>
                        </button>
                    )}
                    {results.length > 0 && (
                        <div className="max-h-[800PX] overflow-y-auto">
                            <ul className="space-y-2">
                                {results.map((result, index) => (
                                    <li
                                        key={index}
                                        className="text-sm p-2 dark:bg-gray-900 bg-gray-200 rounded-md"
                                    >
                                        <strong>{result.page}</strong>
                                        <p
                                            dangerouslySetInnerHTML={{ __html: result.description }}
                                        ></p>
                                        <a
                                            href={result.url}
                                            className="text-blue-500 underline"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                        >
                                            View {result.page}
                                        </a>
                                    </li>
                                ))}
                            </ul>
                        </div>
                    )}
                </div>
            )}
        </div>
    );
};

export default SearchBar;
