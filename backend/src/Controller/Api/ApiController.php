<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Controller\AppController;
use Cake\Http\Response;
use Cake\Log\Log;

/**
 * API Base Controller
 *
 * Base controller for all API endpoints with common functionality
 */
class ApiController extends AppController
{
    /**
     * Initialization hook method.
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        // Set response type to JSON for all API controllers
        $this->viewBuilder()->setClassName('Json');

        // Log API request
        $this->logApiRequest();
    }

    /**
     * Standard API success response
     *
     * @param mixed $data Response data
     * @param string $message Success message
     * @param int $statusCode HTTP status code
     * @return \Cake\Http\Response
     */
    protected function apiResponse(mixed $data = null, string $message = 'Success', int $statusCode = 200): Response
    {
        $response = [
            'success' => true,
            'data' => $data,
            'message' => $message,
        ];

        return $this->response
            ->withStatus($statusCode)
            ->withType('application/json')
            ->withStringBody(json_encode($response));
    }

    /**
     * Standard API error response
     *
     * @param string $message Error message
     * @param int $statusCode HTTP status code
     * @param mixed $errors Error details
     * @return \Cake\Http\Response
     */
    protected function apiError(
        string $message = 'An error occurred',
        int $statusCode = 500,
        mixed $errors = null,
    ): Response {
        $response = [
            'success' => false,
            'data' => null,
            'message' => $message,
        ];

        if ($errors !== null) {
            $response['errors'] = $errors;
        }

        return $this->response
            ->withStatus($statusCode)
            ->withType('application/json')
            ->withStringBody(json_encode($response));
    }

    /**
     * Validation error response
     *
     * @param array $errors Validation errors
     * @param string $message Error message
     * @return \Cake\Http\Response
     */
    protected function apiValidationError(array $errors, string $message = 'Validation failed'): Response
    {
        return $this->apiError($message, 422, $errors);
    }

    /**
     * Not found response
     *
     * @param string $message Error message
     * @return \Cake\Http\Response
     */
    protected function apiNotFound(string $message = 'Resource not found'): Response
    {
        return $this->apiError($message, 404);
    }

    /**
     * Unauthorized response
     *
     * @param string $message Error message
     * @return \Cake\Http\Response
     */
    protected function apiUnauthorized(string $message = 'Unauthorized'): Response
    {
        return $this->apiError($message, 401);
    }

    /**
     * Forbidden response
     *
     * @param string $message Error message
     * @return \Cake\Http\Response
     */
    protected function apiForbidden(string $message = 'Forbidden'): Response
    {
        return $this->apiError($message, 403);
    }

    /**
     * Log API request details
     *
     * @return void
     */
    private function logApiRequest(): void
    {
        $request = $this->request;
        $logData = [
            'method' => $request->getMethod(),
            'url' => $request->getRequestTarget(),
            'ip' => $request->clientIp(),
            'user_agent' => $request->getHeaderLine('User-Agent'),
            'timestamp' => date('Y-m-d H:i:s'),
        ];

        Log::info('API Request: ' . json_encode($logData), ['scope' => ['api']]);
    }

    /**
     * Log API authentication attempts
     *
     * @param string $email User email
     * @param bool $success Whether authentication was successful
     * @param string $reason Failure reason if applicable
     * @return void
     */
    protected function logAuthAttempt(string $email, bool $success, string $reason = ''): void
    {
        $logData = [
            'email' => $email,
            'success' => $success,
            'ip' => $this->request->clientIp(),
            'user_agent' => $this->request->getHeaderLine('User-Agent'),
            'timestamp' => date('Y-m-d H:i:s'),
        ];

        if (!$success && $reason) {
            $logData['reason'] = $reason;
        }

        $level = $success ? 'info' : 'warning';
        $message = $success ? 'Authentication successful' : 'Authentication failed';

        Log::write($level, $message . ': ' . json_encode($logData), ['scope' => ['auth']]);
    }

    /**
     * Log API errors with context
     *
     * @param string $message Error message
     * @param int $statusCode HTTP status code
     * @param array $context Additional context
     * @return void
     */
    protected function logApiError(string $message, int $statusCode, array $context = []): void
    {
        $logData = [
            'message' => $message,
            'status_code' => $statusCode,
            'url' => $this->request->getRequestTarget(),
            'method' => $this->request->getMethod(),
            'ip' => $this->request->clientIp(),
            'timestamp' => date('Y-m-d H:i:s'),
        ];

        if (!empty($context)) {
            $logData['context'] = $context;
        }

        Log::error('API Error: ' . json_encode($logData), ['scope' => ['api']]);
    }
}
