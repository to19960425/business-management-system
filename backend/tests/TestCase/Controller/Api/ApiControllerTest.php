<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Api;

use App\Controller\Api\ApiController;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\TestSuite\TestCase;

/**
 * ApiController Test Case
 */
class ApiControllerTest extends TestCase
{
    /**
     * Test success response format
     *
     * @return void
     */
    public function testSuccessResponseFormat(): void
    {
        $request = new ServerRequest();

        $controller = new class ($request) extends ApiController {
            public function testAction(): Response
            {
                return $this->apiResponse(['test' => 'data'], 'Test message');
            }
        };

        $response = $controller->testAction();
        $body = json_decode((string)$response->getBody(), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getType());
        $this->assertTrue($body['success']);
        $this->assertEquals(['test' => 'data'], $body['data']);
        $this->assertEquals('Test message', $body['message']);
    }

    /**
     * Test error response format
     *
     * @return void
     */
    public function testErrorResponseFormat(): void
    {
        $request = new ServerRequest();

        $controller = new class ($request) extends ApiController {
            public function testAction(): Response
            {
                return $this->apiError('Test error message', 400);
            }
        };

        $response = $controller->testAction();
        $body = json_decode((string)$response->getBody(), true);

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getType());
        $this->assertFalse($body['success']);
        $this->assertNull($body['data']);
        $this->assertEquals('Test error message', $body['message']);
    }

    /**
     * Test validation error response format
     *
     * @return void
     */
    public function testValidationErrorResponseFormat(): void
    {
        $request = new ServerRequest();

        $controller = new class ($request) extends ApiController {
            public function testAction(): Response
            {
                $errors = [
                    'email' => ['This field is required'],
                    'password' => ['This field is required'],
                ];

                return $this->apiValidationError($errors);
            }
        };

        $response = $controller->testAction();
        $body = json_decode((string)$response->getBody(), true);

        $this->assertEquals(422, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getType());
        $this->assertFalse($body['success']);
        $this->assertArrayHasKey('email', $body['errors']);
        $this->assertArrayHasKey('password', $body['errors']);
        $this->assertEquals('Validation failed', $body['message']);
    }
}
