<?php
namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Inertia\Response as InertiaResponse;

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

            // Load your searchable configuration file from config/searchable.php
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

                    // First, remove script tags and known technical JS fragments.
                    $cleanedContent = $this->removeScriptsAndJs($rawContent);
                    // Then filter out debug and technical-related content.
                    $filteredContent = $this->filterTechnicalInfo($cleanedContent);

                    // Convert the filtered content to plain text.
                    $plainContent = $this->htmlToPlainText($filteredContent);
                } catch (\Exception $e) {
                    Log::error("Failed to load page: {$page} - " . $e->getMessage());
                    continue;
                }

                // If the plain text contains the search query, process the result.
                if (stripos($plainContent, $query) !== false) {
                    // Determine URL for the dynamic page.
                    $url = route('dynamic.page', ['page' => $page]);

                    // Determine a snippet and summary.
                    $snippet = $this->extractSnippet($plainContent, $query);
                    $summary = $this->summarizeSnippet($snippet);

                    // Determine the page title from the searchable config if available.
                    $pageTitle = ucfirst($page);
                    $locale = app()->getLocale(); // e.g., 'en' or 'nl'
                    if (isset($searchableConfig[$page])) {
                        // For pages that store title under a locale key.
                        if (isset($searchableConfig[$page][$locale]['hero_title'])) {
                            $pageTitle = $searchableConfig[$page][$locale]['hero_title'];
                        } elseif (isset($searchableConfig[$page]['heroTitle'])) {
                            // For pages that use a different structure.
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
     * Remove script tags and known JavaScript fragments.
     */
    private function removeScriptsAndJs(string $content): string
    {
        // Remove entire <script> blocks
        $content = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $content);
        // Remove common JS fragments
        $jsPatterns = [
            '/document\.head\.append\(.*?\);?/s',
            '/loadNext\(JSON\.parse\(.*?\)\);?/s'
        ];
        foreach ($jsPatterns as $pattern) {
            $content = preg_replace($pattern, '', $content);
        }
        return $content;
    }

    /**
     * Filter out debug and technical-related content from the raw response.
     */
    private function filterTechnicalInfo(string $content): string
    {
        // Keywords and patterns to remove
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
            'document.head.append',
            'loadNext(JSON.parse'
        ];

        foreach ($technicalKeywords as $keyword) {
            // Remove lines or tags that contain technical keywords
            $content = preg_replace('/^.*' . preg_quote($keyword, '/') . '.*$/mi', '', $content);
        }

        // Collapse multiple newlines to simplify content
        $content = preg_replace("/[\r\n]+/", "\n", $content);

        return trim($content);
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
     */
    private function summarizeSnippet(string $snippet): string
    {
        if (empty(trim($snippet))) {
            return "";
        }
        try {
            $openAi = \OpenAI::client(env('OPENAI_API_KEY'));
            $prompt = "Summarize the following text in a friendly, concise manner in no more than 30 words. Ignore any technical or debug information and focus only on describing the content that a visitor would see on the page:\n\n" . $snippet;
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
                return $snippet;
            }
            return $summary;
        } catch (\Exception $e) {
            Log::error("OpenAI Summarization Error: " . $e->getMessage());
            return $snippet;
        }
    }
}
