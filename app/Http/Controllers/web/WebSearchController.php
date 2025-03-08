<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\web\PageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class WebSearchController extends Controller
{
    public function search(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $query = strtolower(trim($request->input('query')));

            if (!$query) {
                return response()->json(['error' => 'Search query is required'], 400);
            }

            Log::info('Search Query:', ['query' => $query]);

            // Pages that we want to search through
            $pages = ['about', 'contact', 'real-estate', 'private-equity', 'agendaEvent', 'masterclass', 'webinar'];

            $results = [];

            foreach ($pages as $page) {
                // Get the page content using PageController
                $response = app(PageController::class)->renderPage($page);

                $content = "";

                // Handling Inertia.js responses
                if ($response instanceof Response) {
                    $pageData = $response->toArray(); // Convert Inertia response to array
                    $content = json_encode($pageData); // Convert it to searchable text
                } elseif (method_exists($response, 'getContent')) {
                    $content = strip_tags($response->getContent()); // Handle normal Blade view responses
                } else {
                    continue; // Skip if there's no content
                }

                // If the search query is found in the content, add it to results
                if (stripos($content, $query) !== false) {
                    $results[] = [
                        'page' => ucfirst($page),
                        'content' => $this->extractMatchingContent($content, $query),
                        'url' => url($page), // Provide the correct page URL
                    ];
                }
            }

            return response()->json([
                'query' => $query,
                'results' => $results,
            ]);
        } catch (\Exception $e) {
            Log::error('Search Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Internal Server Error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Extracts matching content around the searched query.
     */
    private function extractMatchingContent(string $content, string $query, int $window = 50): string
    {
        $position = stripos($content, $query);

        if ($position === false) {
            return "";
        }

        $start = max(0, $position - $window);
        $end = min(strlen($content), $position + strlen($query) + $window);

        $snippet = substr($content, $start, $end - $start);

        return str_replace($query, "<strong>$query</strong>", $snippet);
    }
}
