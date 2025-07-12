<?php
declare(strict_types=1);

namespace App\Middleware;

use Cake\Http\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * CORS Middleware
 *
 * Handles Cross-Origin Resource Sharing (CORS) for API requests
 */
class CorsMiddleware implements MiddlewareInterface
{
    /**
     * Allowed origins
     *
     * @var array<string>
     */
    private array $allowedOrigins = [
        'http://localhost:3000',
        'http://localhost:80',
    ];

    /**
     * Allowed methods
     *
     * @var array<string>
     */
    private array $allowedMethods = [
        'GET',
        'POST',
        'PUT',
        'DELETE',
        'OPTIONS',
    ];

    /**
     * Allowed headers
     *
     * @var array<string>
     */
    private array $allowedHeaders = [
        'Content-Type',
        'Authorization',
    ];

    /**
     * Max age for preflight requests in seconds
     *
     * @var int
     */
    private int $maxAge = 3600;

    /**
     * Process CORS middleware
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request The request
     * @param \Psr\Http\Server\RequestHandlerInterface $handler The handler
     * @return \Psr\Http\Message\ResponseInterface The response
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $uri = $request->getUri();
        $path = $uri->getPath();

        // Only apply CORS to API routes
        if (!str_starts_with($path, '/api/')) {
            return $handler->handle($request);
        }

        $origin = $request->getHeaderLine('Origin');

        // Handle preflight OPTIONS request
        if ($request->getMethod() === 'OPTIONS') {
            $response = new Response();

            return $this->addCorsHeaders($response, $origin);
        }

        // Process the request and add CORS headers to response
        $response = $handler->handle($request);

        return $this->addCorsHeaders($response, $origin);
    }

    /**
     * Add CORS headers to response
     *
     * @param \Psr\Http\Message\ResponseInterface $response The response
     * @param string $origin The origin header from request
     * @return \Psr\Http\Message\ResponseInterface The response with CORS headers
     */
    private function addCorsHeaders(ResponseInterface $response, string $origin): ResponseInterface
    {
        // Check if origin is allowed
        if (!empty($origin) && in_array($origin, $this->allowedOrigins)) {
            $response = $response->withHeader('Access-Control-Allow-Origin', $origin);
        }

        $response = $response
            ->withHeader('Access-Control-Allow-Methods', implode(', ', $this->allowedMethods))
            ->withHeader('Access-Control-Allow-Headers', implode(', ', $this->allowedHeaders))
            ->withHeader('Access-Control-Max-Age', (string)$this->maxAge);

        return $response;
    }
}
