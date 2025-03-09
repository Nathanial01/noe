<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Inertia\Response as InertiaResponse;
use App\Http\Controllers\web\PageController; // Ensure correct namespace

class WebSearchController extends Controller
{
    /**
     * Search public pages and return advanced AI-generated results.
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $query = strtolower(trim($request->input('query')));
            if (!$query) {
                return response()->json(['error' => 'Search query is required'], 400);
            }
            Log::info('Search Query:', ['query' => $query]);

            // Define public pages to search – keys must match your PageController mapping.
            $pages = [
                'about',
                'our-story',
                'contact',
                'real-estate',
                'private-equity',
                'agendaevent',
                'masterclass',
                'webinar'
            ];
            $results = [];

            // Load searchable configuration file from config/searchable.php
            $searchableConfig = config('searchable');

            foreach ($pages as $page) {
                try {
                    // Render the page via PageController.
                    $response = app(PageController::class)->renderPage($page);

                    // Convert Inertia responses to HTTP responses if needed.
                    if ($response instanceof InertiaResponse) {
                        $httpResponse = $response->toResponse($request);
                        $rawContent = $httpResponse->getContent();
                    } elseif (method_exists($response, 'getContent')) {
                        $rawContent = $response->getContent();
                    } else {
                        $rawContent = json_encode($response);
                    }

                    // Filter out technical-related content.
                    $filteredRawContent = $this->filterTechnicalInfo($rawContent);

                    // Convert the filtered content to plain text.
                    $plainContent = $this->htmlToPlainText($filteredRawContent);
                } catch (\Exception $e) {
                    Log::error("Failed to load page: {$page} - " . $e->getMessage());
                    continue;
                }

                // Check if the plain text contains the search query.
                if (stripos($plainContent, $query) !== false) {
                    $url = route('dynamic.page', ['page' => $page]);
                    $snippet = $this->extractSnippet($plainContent, $query);

                    // Further clean the snippet by removing any remaining technical fragments.
                    $cleanSnippet = $this->cleanSnippet($snippet);
                    $summary = $this->summarizeSnippet($cleanSnippet);

                    // Determine the page title from the searchable config if available.
                    $pageTitle = ucfirst($page);
                    $locale = app()->getLocale();
                    if (isset($searchableConfig[$page])) {
                        if (isset($searchableConfig[$page][$locale]['hero_title'])) {
                            $pageTitle = $searchableConfig[$page][$locale]['hero_title'];
                        } elseif (isset($searchableConfig[$page]['heroTitle'])) {
                            $pageTitle = $searchableConfig[$page]['heroTitle'];
                        }
                    }

                    $results[] = [
                        'page'        => $pageTitle,
                        'description' => $summary,
                        'url'         => $url,
                    ];
                }
            }

            if (empty($results)) {
                return response()->json([
                    'query'   => $query,
                    'results' => [],
                    'message' => 'No results found. Please try a different search term.',
                ]);
            }

            return response()->json([
                'query'   => $query,
                'results' => $results,
            ]);
        } catch (\Exception $e) {
            Log::error('Search Error: ' . $e->getMessage());
            return response()->json([
                'error'   => 'Internal Server Error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Filter out technical-related content from the raw response by removing keywords,
     * JSON blocks, and route tokens.
     */
    private function filterTechnicalInfo(string $content): string
    {
        // List of general technical keywords to remove.
        $technicalKeywords = [
            'Ziggy',
            'debugbar',
            'clockwork',
            'asset(',
            'route(',
            'DEBUG',
            'debug',
            'Debug information:',
            'Route listing:',
            'Generated by',
            '/css/',
            '/js/',
            '/storage/',
            '/images/',
            '<!--',
            '-->',
            // HTTP method and route-related tokens.
            'GET ',
            'POST ',
            'PUT ',
            'DELETE ',
            'PATCH ',
            'OPTIONS ',
            'HTTP/',
            'ssh',
            'vite',
            'react',
            'vue',
            'laravel',
            'dynamic.page',
            'profile.destroy',
            'admin.index',
            'password.request',
            'register',
            'uri',
            'methods',
            'wheres',
            'parameters',
            'Https',
            'Http',
            'SSH',
            'User',
            'Admin'
        ];

        foreach ($technicalKeywords as $keyword) {
            $content = str_ireplace($keyword, '', $content);
        }

        // List of internal keys whose JSON blocks or arrays should be removed entirely.
        $keysToRemove = [
            'profile.edit',
            'dashboard',
            'relatedResource',
            'relatedResourceId',
            'profile.update',
            'forgot-password',
            'token',
            'verification.noti',
            'password.email',
            'password.reset',
            'password.store'
        ];

        foreach ($keysToRemove as $key) {
            // Remove JSON object blocks for the key.
            $patternObject = '/"' . preg_quote($key, '/') . '"\s*:\s*\{[^}]+\},?/i';
            $content = preg_replace($patternObject, '', $content);
            // Remove JSON array blocks for the key.
            $patternArray = '/"' . preg_quote($key, '/') . '"\s*:\s*\[[^\]]+\],?/i';
            $content = preg_replace($patternArray, '', $content);
        }

        // Remove any remaining JSON blocks that contain "uri" definitions.
        $content = preg_replace('/\{[^}]*"uri":\s*".*?"[^}]*\},?/s', '', $content);
        // Remove any JSON objects that contain HTTP method arrays.
        $content = preg_replace('/\{[^}]*\[[\sA-Z",]+\][^}]*\},?/i', '', $content);
        // Remove any route tokens wrapped in curly braces.
        $content = preg_replace('/\/\{[^}]+\}/', '', $content);
        // Remove stray prefixes such as "hed\/".
        $content = str_ireplace('hed\/', '', $content);
        // Collapse multiple newlines into one.
        $content = preg_replace("/[\r\n]+/", "\n", $content);

        return trim($content);
    }

    /**
     * Further clean the snippet by removing any remaining content inside curly braces,
     * and extra fragments such as "loadNext(JSON.parse(...))" or bracketed text.
     */
    private function cleanSnippet(string $snippet): string
    {
        // Remove any content enclosed in curly braces.
        $cleaned = preg_replace('/\{[^}]+\}/', '', $snippet);
        // Remove patterns like loadNext(JSON.parse(...))
        $cleaned = preg_replace('/loadNext\(JSON\.parse\([^)]*\)\)/i', '', $cleaned);
        // Remove content inside square brackets (if they appear on their own).
        $cleaned = preg_replace('/\[[^\]]+\]/', '', $cleaned);
        // Remove extra whitespace.
        return trim(preg_replace('/\s+/', ' ', $cleaned));
    }

    /**
     * Convert HTML to plain text using DOMDocument.
     */
    private function htmlToPlainText(string $html): string
    {
        libxml_use_internal_errors(true);
        $doc = new \DOMDocument();
        $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
        if ($doc->loadHTML($html)) {
            $text = $doc->textContent;
            return trim($text);
        }
        return trim(strip_tags($html));
    }

    /**
     * Extracts a snippet of text around the search query.
     */
    private function extractSnippet(string $content, string $query, int $window = 200): string
    {
        $position = mb_stripos($content, $query);
        if ($position === false) {
            return "";
        }
        $start = max(0, $position - $window);
        $end = min(mb_strlen($content), $position + mb_strlen($query) + $window);
        return mb_substr($content, $start, $end - $start);
    }

    /**
     * Summarize the snippet using OpenAI GPT-3.5 Turbo (limit to ~30 words).
     * If the snippet contains technical content or if an error occurs, return the original snippet.
     */
    private function summarizeSnippet(string $snippet): string
    {
        $trimmedSnippet = trim($snippet);
        if (empty($trimmedSnippet)) {
            Log::warning('Empty snippet provided for summarization.');
            return "";
        }

        // Skip summarization if technical markers are detected.
        if (preg_match('/<\?php|<code>|<\/code>|function\s+\w+\s*\(|public\s+function|class\s+\w+|GET\s+\/|POST\s+\/|PUT\s+\/|DELETE\s+\/|HTTP\//i', $trimmedSnippet)) {
            Log::info('Snippet contains technical content; skipping summarization.', [
                'snippet' => $trimmedSnippet,
            ]);
            return $trimmedSnippet;
        }
//dfsfsfs
        try {
            $prompt = "Summarize the following text in a friendly, concise manner in no more than 12 words. Exclude any references to URIs, HTTP methods, routes, or technical information. Focus only on visitor-facing content such as key messages or topics like investment and real estate:\n\n" . $trimmedSnippet;

            // Log the prompt for debugging.
            Log::debug('Summarization prompt:', ['prompt' => $prompt]);

            $openAi = \OpenAI::client(env('OPENAI_API_KEY'));
            $response = $openAi->chat()->create([
                'model'       => 'gpt-3.5-turbo',
                'messages'    => [
                    ['role' => 'system', 'content' => $prompt],
                ],
                'max_tokens'  => 60,
                'temperature' => 0.5,
            ]);

            $summary = $response['choices'][0]['message']['content'] ?? '';
            $summary = trim($summary);

            if (empty($summary) || stripos($summary, "i'm sorry") !== false) {
                Log::warning('Summarization returned empty or fallback response.', [
                    'prompt' => $prompt,
                    'original_snippet' => $trimmedSnippet,
                    'response' => $summary,
                ]);
                return $trimmedSnippet;
            }
            return $summary;
        } catch (\Exception $e) {
            Log::error("OpenAI Summarization Error: " . $e->getMessage(), [
                'snippet' => $trimmedSnippet,
            ]);
            return $trimmedSnippet;
        }
    }
}
