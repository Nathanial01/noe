import React, { useState, useEffect, useCallback } from "react";
import axios from "axios";

const API_BASE_URL = "https://noecapital-24a1e658d2d0.herokuapp.com";

const SearchBar = () => {
const [expanded, setExpanded] = useState(false);
const [query, setQuery] = useState("");
const [results, setResults] = useState([]);
const [loading, setLoading] = useState(false);
const [error, setError] = useState("");

// Fetch CSRF Token
const fetchCsrfToken = async () => {
await axios.get(`${API_BASE_URL}/sanctum/csrf-cookie`);
};

// Function to fetch search results dynamically
const fetchResults = useCallback(async () => {
if (!query.trim()) return;

setLoading(true);
setError("");
setResults([]);

try {
await fetchCsrfToken();  // ✅ Ensure CSRF token is set

const response = await axios.post(
`${API_BASE_URL}/api/search`,
{ query },
{ withCredentials: true }  // ✅ Send cookies
);

setResults(response.data.results || []);
} catch (err) {
setError(err.response?.data?.error || "Search failed. Please try again.");
} finally {
setLoading(false);
}
}, [query]);

// Debounce the search function (waits 500ms before making API call)
useEffect(() => {
if (query.length > 2) {
const delayDebounce = setTimeout(() => {
fetchResults();
}, 500);

return () => clearTimeout(delayDebounce);
}
}, [query, fetchResults]);

return (
<div className="relative">
    {/* Search Bar */}
    <div
        onClick={() => setExpanded(true)}
    className={`p-5 overflow-hidden h-10 rounded-full flex group items-center duration-300
    ${expanded ? "w-[270px] opacity-100 bg-gray-600/80 backdrop-blur-3xl" : "w-5 opacity-100 "}
    md:w-[270px] md:opacity-100 md:bg-gray-400 dark:md:bg-gray-800 md:backdrop-blur-3xl
    `}
    >
    {/* Search Icon */}
    <div className="flex items-center justify-center fill-white mr-8">
        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            width="16"
            height="16"
        >
            <path d="M18.9,16.776A10.539,10.539,0,1,0,16.776,18.9l5.1,5.1L24,21.88ZM10.5,18A7.5,7.5,0,1,1,18,10.5,7.507,7.507,0,0,1,10.5,18Z"></path>
        </svg>
    </div>

    {/* Input Field */}
    <input
        type="text"
        name="q"
        autoCapitalize="off"
        autoComplete="off"
        title="Search"
        role="combobox"
        placeholder="Search Now"
        className="outline-none bg-transparent border-0 w-full font-normal px-4 focus:border-0 focus:ring-0"
        value={query}
        onChange={(e) => setQuery(e.target.value)}
    />

    <span className="hidden sm:block">⌘</span>K
</div>

{/* Loading State */}
{loading && <p className="text-sm text-gray-400 mt-2">Searching...</p>}

{/* Error Message */}
{error && <p className="text-sm text-red-500 mt-2">{error}</p>}

{/* Search Results */}
{results.length > 0 && (
<div className="absolute top-12 left-0 w-[270px] bg-white shadow-lg rounded-lg p-3">
    <h3 className="text-gray-700 font-semibold mb-2">Results:</h3>
    <ul className="space-y-2">
        {results.map((result, index) => (
        <li key={index} className="text-gray-800 text-sm p-2 bg-gray-100 rounded-md">
            <strong>{result.page}</strong>
            <p>{result.content}</p>
        </li>
        ))}
    </ul>
</div>
)}
</div>
);
};

export default SearchBar;
