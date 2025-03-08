<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CorsMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Allowed origins for CORS—adjust to your local port if necessary
        $allowedOrigins = [
            'http://localhost',
            'http://localhost:5173', // Example: your local React/Vite app
            'https://noecapital-24a1e658d2d0.herokuapp.com', // Production domain
        ];

        $origin = $request->headers->get('origin');
        if (in_array($origin, $allowedOrigins)) {
            $response->headers->set('Access-Control-Allow-Origin', $origin);
        }
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
        $response->headers->set('Access-Control-Allow-Credentials', 'true');

        // Handle preflight OPTIONS request
        if ($request->getMethod() === "OPTIONS") {
            return response()->json('{"status":"OK"}', 200, $response->headers->all());
        }

        return $response;
    }
}
