<?php
declare(strict_types=1);

namespace App\Test\TestCase\Middleware;

use App\Middleware\ApiCsrfProtectionMiddleware;
use Cake\Http\ServerRequest;
use Cake\TestSuite\TestCase;

/**
 * ApiCsrfProtectionMiddleware Test Case
 */
class ApiCsrfProtectionMiddlewareTest extends TestCase
{
    protected ApiCsrfProtectionMiddleware $middleware;

    /**
     * setUp method
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->middleware = new ApiCsrfProtectionMiddleware();
    }

    /**
     * tearDown method
     */
    public function tearDown(): void
    {
        unset($this->middleware);
        parent::tearDown();
    }

    /**
     * Test that OPTIONS requests are allowed without CSRF token
     */
    public function testOptionsRequestSkipsCsrf(): void
    {
        $request = new ServerRequest([
            'environment' => [
                'REQUEST_METHOD' => 'OPTIONS',
                'REQUEST_URI' => '/api/v1/auth/login',
            ],
        ]);

        $shouldSkip = $this->middleware->shouldSkipCsrfCheck($request);

        $this->assertTrue($shouldSkip);
    }

    /**
     * Test that JWT authenticated requests skip CSRF
     */
    public function testJwtAuthenticatedRequestSkipsCsrf(): void
    {
        $request = new ServerRequest([
            'environment' => [
                'REQUEST_METHOD' => 'POST',
                'REQUEST_URI' => '/api/v1/test/protected',
                'HTTP_AUTHORIZATION' => 'Bearer valid-jwt-token',
            ],
        ]);

        $shouldSkip = $this->middleware->shouldSkipCsrfCheck($request);

        $this->assertTrue($shouldSkip);
    }

    /**
     * Test that non-API routes are passed through unchanged
     */
    public function testNonApiRoutesPassThrough(): void
    {
        $request = new ServerRequest([
            'environment' => [
                'REQUEST_METHOD' => 'POST',
                'REQUEST_URI' => '/admin/dashboard',
            ],
        ]);

        $shouldSkip = $this->middleware->shouldSkipCsrfCheck($request);

        $this->assertTrue($shouldSkip);
    }

    /**
     * Test that login and refresh endpoints skip CSRF
     */
    public function testAuthEndpointsSkipCsrf(): void
    {
        $loginRequest = new ServerRequest([
            'environment' => [
                'REQUEST_METHOD' => 'POST',
                'REQUEST_URI' => '/api/v1/auth/login',
            ],
        ]);

        $shouldSkip = $this->middleware->shouldSkipCsrfCheck($loginRequest);
        $this->assertTrue($shouldSkip);

        $refreshRequest = new ServerRequest([
            'environment' => [
                'REQUEST_METHOD' => 'POST',
                'REQUEST_URI' => '/api/v1/auth/refresh',
            ],
        ]);

        $shouldSkip = $this->middleware->shouldSkipCsrfCheck($refreshRequest);
        $this->assertTrue($shouldSkip);
    }

    /**
     * Test that regular API requests require CSRF
     */
    public function testRegularApiRequestsRequireCsrf(): void
    {
        $request = new ServerRequest([
            'environment' => [
                'REQUEST_METHOD' => 'POST',
                'REQUEST_URI' => '/api/v1/staff',
            ],
        ]);

        $shouldSkip = $this->middleware->shouldSkipCsrfCheck($request);

        $this->assertFalse($shouldSkip);
    }
}
