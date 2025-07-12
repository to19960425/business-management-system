<?php
declare(strict_types=1);

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Cake\Http\Response;
use App\Service\JwtService;

/**
 * JWT Authentication Middleware
 * 
 * Handles JWT token validation for protected routes
 */
class JwtAuthenticationMiddleware implements MiddlewareInterface
{
    protected JwtService $jwtService;
    
    protected array $publicRoutes = [
        '/api/v1/auth/login',
        '/api/v1/auth/refresh',
        '/api/v1/health',
        '/api/v1/health/database',
    ];
    
    public function __construct()
    {
        $this->jwtService = new JwtService();
    }
    
    /**
     * Process the request
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Server\RequestHandlerInterface $handler
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $uri = $request->getUri()->getPath();
        
        // Skip authentication for public routes
        if ($this->isPublicRoute($uri)) {
            return $handler->handle($request);
        }
        
        // Skip authentication for non-API routes
        if (!str_starts_with($uri, '/api/')) {
            return $handler->handle($request);
        }
        
        // Check for Authorization header
        $authHeader = $request->getHeaderLine('Authorization');
        
        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return $this->createUnauthorizedResponse('Missing or invalid authorization header');
        }
        
        // Extract token
        $token = substr($authHeader, 7);
        
        // Validate token
        $payload = $this->jwtService->validateToken($token);
        
        if (!$payload) {
            return $this->createUnauthorizedResponse('Invalid or expired token');
        }
        
        // Add user information to request attributes
        $request = $request->withAttribute('user_id', $payload['sub']);
        $request = $request->withAttribute('user_email', $payload['email'] ?? null);
        $request = $request->withAttribute('user_role', $payload['role'] ?? null);
        
        return $handler->handle($request);
    }
    
    /**
     * Check if the route is public (doesn't require authentication)
     *
     * @param string $uri
     * @return bool
     */
    protected function isPublicRoute(string $uri): bool
    {
        foreach ($this->publicRoutes as $route) {
            if ($uri === $route) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Create an unauthorized response
     *
     * @param string $message
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function createUnauthorizedResponse(string $message): ResponseInterface
    {
        $response = new Response();
        $response = $response->withStatus(401);
        $response = $response->withType('application/json');
        
        $body = json_encode([
            'success' => false,
            'message' => $message,
            'data' => null,
        ]);
        
        $response->getBody()->write($body);
        
        return $response;
    }
}