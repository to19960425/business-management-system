<?php
declare(strict_types=1);

namespace App\Middleware;

use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * API CSRF Protection Middleware
 *
 * Provides CSRF protection for API routes with proper exceptions for:
 * - OPTIONS requests (CORS preflight)
 * - JWT authenticated requests
 * - Auth endpoints (login, refresh)
 */
class ApiCsrfProtectionMiddleware implements MiddlewareInterface
{
    private CsrfProtectionMiddleware $csrfMiddleware;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->csrfMiddleware = new CsrfProtectionMiddleware([
            'httponly' => true,
            'secure' => true,
            'skipCheckCallback' => [$this, 'shouldSkipCsrfCheck'],
        ]);
    }

    /**
     * Process the request through CSRF protection
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request The request
     * @param \Psr\Http\Server\RequestHandlerInterface $handler The handler
     * @return \Psr\Http\Message\ResponseInterface The response
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return $this->csrfMiddleware->process($request, $handler);
    }

    /**
     * Determine if CSRF check should be skipped for this request
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request The request
     * @return bool True if CSRF check should be skipped
     */
    public function shouldSkipCsrfCheck(ServerRequestInterface $request): bool
    {
        $uri = $request->getUri();
        $path = $uri->getPath();
        $method = $request->getMethod();

        // Skip for non-API routes
        if (!str_starts_with($path, '/api/')) {
            return true;
        }

        // Skip for OPTIONS requests (CORS preflight)
        if ($method === 'OPTIONS') {
            return true;
        }

        // Skip for JWT authenticated requests
        $authHeader = $request->getHeaderLine('Authorization');
        if (str_starts_with($authHeader, 'Bearer ')) {
            return true;
        }

        // Skip for auth endpoints (login, refresh)
        $authEndpoints = [
            '/api/v1/auth/login',
            '/api/v1/auth/refresh',
        ];

        if (in_array($path, $authEndpoints, true)) {
            return true;
        }

        // Require CSRF for all other API requests
        return false;
    }
}
