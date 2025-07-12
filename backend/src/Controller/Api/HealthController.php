<?php
declare(strict_types=1);

namespace App\Controller\Api;

use Cake\Http\Response;
use Exception;

/**
 * Health Controller
 *
 * Provides health check endpoints for API monitoring
 */
class HealthController extends ApiController
{
    /**
     * Basic health check
     *
     * @return \Cake\Http\Response
     */
    public function check(): Response
    {
        $data = [
            'status' => 'healthy',
            'timestamp' => date('c'),
            'version' => '1.0.0',
        ];

        return $this->apiResponse($data, 'Service is healthy');
    }

    /**
     * Database health check
     *
     * @return \Cake\Http\Response
     */
    public function database(): Response
    {
        try {
            $connection = $this->getTableLocator()->get('Users')->getConnection();
            $connection->execute('SELECT 1');

            $data = [
                'database' => 'connected',
                'timestamp' => date('c'),
            ];

            return $this->apiResponse($data, 'Database connection is healthy');
        } catch (Exception $e) {
            return $this->apiError('Database connection failed: ' . $e->getMessage(), 503);
        }
    }
}
