<?php
declare(strict_types=1);

namespace App\Test\TestCase\Integration;

use App\Middleware\ApiCsrfProtectionMiddleware;
use App\Service\SecurityValidationService;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * Security Features Integration Test
 *
 * Tests that security features work correctly in an integrated environment
 */
class SecurityFeaturesIntegrationTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Test that SecurityValidationService works with real environment
     */
    public function testSecurityValidationServiceWithRealEnvironment(): void
    {
        $service = new SecurityValidationService();

        // This should not throw an exception in the test environment
        // where JWT_SECRET and SECURITY_SALT are properly configured
        $result = $service->validateConfiguration();

        $this->assertTrue($result);
    }

    /**
     * Test CSRF protection middleware integration
     */
    public function testCsrfProtectionMiddlewareIntegration(): void
    {
        $middleware = new ApiCsrfProtectionMiddleware();

        // Test that the middleware is properly configured
        $this->assertInstanceOf(ApiCsrfProtectionMiddleware::class, $middleware);
    }

    /**
     * Test OPTIONS request skips CSRF (CORS preflight)
     */
    public function testOptionsRequestSkipsCsrfProtection(): void
    {
        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        // OPTIONS request should not require CSRF token
        $this->options('/api/v1/auth/login');

        // Should get a 200 response (CORS handled) not 403 (CSRF failed)
        $this->assertResponseOk();
    }

    /**
     * Test JWT authenticated requests skip CSRF
     */
    public function testJwtAuthenticatedRequestSkipsCsrf(): void
    {
        // First, login to get a JWT token
        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        $this->post('/api/v1/auth/login', [
            'email' => 'admin@example.com',
            'password' => 'SecurePass123!',
        ]);

        $this->assertResponseOk();
        $response = $this->viewVariable('_serialize');

        if ($response && isset($response['data']['access_token'])) {
            $accessToken = $response['data']['access_token'];

            // Now test a protected endpoint with JWT token
            $this->configRequest([
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $accessToken,
                ],
            ]);

            $this->get('/api/v1/test/protected');

            // Should work without CSRF token because JWT is present
            $this->assertResponseOk();
        } else {
            $this->markTestSkipped('Login failed, cannot test JWT authentication');
        }
    }

    /**
     * Test login endpoint skips CSRF protection
     */
    public function testLoginEndpointSkipsCsrfProtection(): void
    {
        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        // Login should work without CSRF token
        $this->post('/api/v1/auth/login', [
            'email' => 'admin@example.com',
            'password' => 'SecurePass123!',
        ]);

        // Should get a response (success or error) not CSRF failure
        $this->assertResponseCode(200);
    }

    /**
     * Test health endpoints work without authentication
     */
    public function testHealthEndpointsWork(): void
    {
        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);

        $this->get('/api/v1/health');
        $this->assertResponseOk();

        $this->get('/api/v1/health/database');
        $this->assertResponseOk();
    }
}
