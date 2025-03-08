import React, { useState, useEffect, useCallback } from "react";
import axios from "axios";

// Set API base URL based on environment.
const API_BASE_URL =
    window.location.hostname === "localhost"
        ? "http://localhost"
        : "https://noecapital-24a1e658d2d0.herokuapp.com";

const SearchBar = () => {
    const [query, setQuery] = useState("");
    const [results, setResults] = useState([]);
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState("");

    // Default placeholder text for the search input.
    const placeholderText = "How can I help you?";

    // Fetch CSRF token on mount (if using Laravel Sanctum).
    useEffect(() => {
        axios.get(`${API_BASE_URL}/sanctum/csrf-cookie`, { withCredentials: true })
            .catch(err => console.error("CSRF Token Error:", err));
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

    // Debounce search input with a 500ms delay on every input change.
    useEffect(() => {
        const delayDebounce = setTimeout(() => {
            fetchResults();
        }, 500);
        return () => clearTimeout(delayDebounce);
    }, [query, fetchResults]);

    return (
        <div className="relative">
            <div className="p-5 overflow-hidden h-10 rounded-full flex items-center duration-300 bg-gray-600/80 backdrop-blur-3xl">
                <div className="flex items-center justify-center mr-8">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16">
                        <path d="M18.9,16.776A10.539,10.539,0,1,0,16.776,18.9l5.1,5.1L24,21.88ZM10.5,18A7.5,7.5,0,1,1,18,10.5,7.507,7.507,0,0,1,10.5,18Z"></path>
                    </svg>
                </div>
                <input
                    type="text"
                    placeholder={placeholderText}
                    className="outline-none bg-transparent border-0 w-full font-normal px-4 focus:ring-0"
                    value={query}
                    onChange={(e) => setQuery(e.target.value)}
                />
                <span className="hidden sm:block">⌘</span>K
            </div>

            {loading && <p className="text-sm text-gray-400 mt-2">Searching...</p>}
            {error && <p className="text-sm text-red-500 mt-2">{error}</p>}
            {(!loading && query.trim() && results.length === 0) && (
                <p className="text-sm text-gray-500 mt-2">No results found. Please try another search term.</p>
            )}

            {results.length > 0 && (
                <div className="absolute top-12 left-0 w-[270px] bg-white shadow-lg rounded-lg p-3">
                    <h3 className="text-gray-700 font-semibold mb-2">Results:</h3>
                    <ul className="space-y-2">
                        {results.map((result, index) => (
                            <li key={index} className="text-gray-800 text-sm p-2 bg-gray-100 rounded-md">
                                <strong>{result.page}</strong>
                                <p dangerouslySetInnerHTML={{ __html: result.description }}></p>
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
    );
};

export default SearchBar;
