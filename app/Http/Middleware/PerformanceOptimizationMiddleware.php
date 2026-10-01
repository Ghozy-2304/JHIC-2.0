<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PerformanceOptimizationMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        // Apply Security & Performance Headers
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Apply Cache-Control for GET requests on non-admin routes
        if ($request->isMethod('GET') && !$request->is('admin*') && !$request->is('api*')) {
            if (!$response->headers->has('Cache-Control')) {
                $response->headers->set('Cache-Control', 'public, max-age=3600, s-maxage=3600');
            }
        }

        // Automatic Gzip Compression for HTML/Text responses if supported by client
        if (function_exists('gzencode')
            && str_contains($request->header('Accept-Encoding', ''), 'gzip')
            && !$response->headers->has('Content-Encoding')
            && !in_array($response->getStatusCode(), [204, 304])
            && is_string($response->getContent())
            && strlen($response->getContent()) > 1024) {
            
            $compressed = gzencode($response->getContent(), 6);
            if ($compressed !== false) {
                $response->setContent($compressed);
                $response->headers->set('Content-Encoding', 'gzip');
                $response->headers->set('Content-Length', (string) strlen($compressed));
            }
        }

        return $response;
    }
}
