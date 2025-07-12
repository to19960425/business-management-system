<?php
declare(strict_types=1);

namespace App\Controller\Api;

use Cake\Http\Response;

/**
 * Test Controller
 * 
 * Provides test endpoints for authentication verification
 */
class TestController extends ApiController
{
    /**
     * Protected endpoint for testing JWT authentication
     *
     * @return \Cake\Http\Response
     */
    public function protected(): Response
    {
        $userId = $this->request->getAttribute('user_id');
        $userEmail = $this->request->getAttribute('user_email');
        $userRole = $this->request->getAttribute('user_role');
        
        return $this->apiResponse([
            'message' => 'Access granted to protected endpoint',
            'user_id' => $userId,
            'user_email' => $userEmail,
            'user_role' => $userRole,
            'timestamp' => date('c'),
        ], 'Protected resource accessed successfully');
    }
}