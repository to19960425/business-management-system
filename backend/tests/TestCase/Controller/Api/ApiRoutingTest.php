<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Api;

use App\Controller\Api\AuthController;
use App\Controller\Api\HealthController;
use Cake\Http\ServerRequest;
use Cake\TestSuite\TestCase;

/**
 * API Controller Functionality Test Case
 */
class ApiRoutingTest extends TestCase
{
    /**
     * Test Health controller returns proper API format
     *
     * @return void
     */
    public function testHealthControllerApiFormat(): void
    {
        $request = new ServerRequest([
            'url' => '/api/v1/health',
            'environment' => ['REQUEST_METHOD' => 'GET'],
        ]);

        $controller = new HealthController($request);
        $result = $controller->check();

        $this->assertEquals(200, $result->getStatusCode());
        $this->assertEquals('application/json', $result->getType());
    }

    /**
     * Test Auth controller returns proper API format for invalid login
     *
     * @return void
     */
    public function testAuthControllerApiFormat(): void
    {
        $request = new ServerRequest([
            'url' => '/api/v1/auth/login',
            'environment' => ['REQUEST_METHOD' => 'POST'],
            'post' => ['email' => 'test@example.com', 'password' => 'password'],
        ]);

        $controller = new AuthController($request);
        $result = $controller->login();

        $this->assertEquals(401, $result->getStatusCode());
        $this->assertEquals('application/json', $result->getType());
    }

    /**
     * Test Auth controller validates required fields
     *
     * @return void
     */
    public function testAuthControllerValidation(): void
    {
        $request = new ServerRequest([
            'url' => '/api/v1/auth/login',
            'environment' => ['REQUEST_METHOD' => 'POST'],
            'post' => [],
        ]);

        $controller = new AuthController($request);
        $result = $controller->login();

        $this->assertEquals(422, $result->getStatusCode());
        $this->assertEquals('application/json', $result->getType());
    }

    /**
     * Test Auth controller rejects non-POST requests
     *
     * @return void
     */
    public function testAuthControllerMethodValidation(): void
    {
        $request = new ServerRequest([
            'url' => '/api/v1/auth/login',
            'environment' => ['REQUEST_METHOD' => 'GET'],
        ]);

        $controller = new AuthController($request);
        $result = $controller->login();

        $this->assertEquals(405, $result->getStatusCode());
        $this->assertEquals('application/json', $result->getType());
    }
}
