<?php
declare(strict_types=1);

namespace App\Test\TestCase\Middleware;

use App\Middleware\CorsMiddleware;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\TestSuite\TestCase;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * CorsMiddleware Test Case
 */
class CorsMiddlewareTest extends TestCase
{
    /**
     * Test CORS headers are added to response
     *
     * @return void
     */
    public function testCorsHeadersAreAdded(): void
    {
        $middleware = new CorsMiddleware();
        $request = new ServerRequest([
            'url' => '/api/v1/test',
            'environment' => [
                'REQUEST_METHOD' => 'GET',
                'HTTP_ORIGIN' => 'http://localhost:3000',
            ],
        ]);
        $response = new Response();

        $handler = $this->createMock(RequestHandlerInterface::class);
        $handler->expects($this->once())
            ->method('handle')
            ->with($request)
            ->willReturn($response);

        $result = $middleware->process($request, $handler);

        $this->assertEquals('http://localhost:3000', $result->getHeaderLine('Access-Control-Allow-Origin'));
        $this->assertEquals('GET, POST, PUT, DELETE, OPTIONS', $result->getHeaderLine('Access-Control-Allow-Methods'));
        $this->assertEquals('Content-Type, Authorization', $result->getHeaderLine('Access-Control-Allow-Headers'));
        $this->assertEquals('3600', $result->getHeaderLine('Access-Control-Max-Age'));
    }

    /**
     * Test OPTIONS request returns appropriate response
     *
     * @return void
     */
    public function testOptionsRequestReturnsOkResponse(): void
    {
        $middleware = new CorsMiddleware();
        $request = new ServerRequest([
            'url' => '/api/v1/test',
            'environment' => [
                'REQUEST_METHOD' => 'OPTIONS',
                'HTTP_ORIGIN' => 'http://localhost:3000',
            ],
        ]);

        $handler = $this->createMock(RequestHandlerInterface::class);
        $handler->expects($this->never())
            ->method('handle');

        $result = $middleware->process($request, $handler);

        $this->assertEquals(200, $result->getStatusCode());
        $this->assertEquals('http://localhost:3000', $result->getHeaderLine('Access-Control-Allow-Origin'));
    }

    /**
     * Test CORS headers are not added for non-API requests
     *
     * @return void
     */
    public function testCorsHeadersNotAddedForNonApiRequests(): void
    {
        $middleware = new CorsMiddleware();
        $request = new ServerRequest([
            'url' => '/pages/home',
            'environment' => [
                'REQUEST_METHOD' => 'GET',
                'HTTP_ORIGIN' => 'http://localhost:3000',
            ],
        ]);
        $response = new Response();

        $handler = $this->createMock(RequestHandlerInterface::class);
        $handler->expects($this->once())
            ->method('handle')
            ->with($request)
            ->willReturn($response);

        $result = $middleware->process($request, $handler);

        $this->assertEquals('', $result->getHeaderLine('Access-Control-Allow-Origin'));
    }
}
