<?php
declare(strict_types=1);

namespace App\Controller\Api;

use Cake\Http\Response;
use App\Service\JwtService;
use App\Model\Table\UsersTable;

/**
 * Auth Controller
 *
 * Handles authentication endpoints
 */
class AuthController extends ApiController
{
    protected UsersTable $Users;
    protected JwtService $jwtService;
    
    /**
     * Initialize controller
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->Users = $this->fetchTable('Users');
        $this->jwtService = new JwtService();
    }
    /**
     * Login endpoint
     *
     * @return \Cake\Http\Response
     */
    public function login(): Response
    {
        if (!$this->request->is('post')) {
            return $this->apiError('Only POST method is allowed', 405);
        }

        $data = $this->request->getData();

        // Validate required fields
        if (empty($data['email']) || empty($data['password'])) {
            $errors = [];
            if (empty($data['email'])) {
                $errors['email'] = ['Email is required'];
            }
            if (empty($data['password'])) {
                $errors['password'] = ['Password is required'];
            }

            $this->logApiError('Login validation failed', 422, $errors);

            return $this->apiValidationError($errors);
        }

        try {
            // Find user by email
            $user = $this->Users->find()
                ->where(['email' => $data['email'], 'active' => true])
                ->first();

            if (!$user) {
                $this->logAuthAttempt($data['email'], false, 'User not found');
                return $this->apiUnauthorized('Invalid credentials');
            }

            // Verify password
            if (!password_verify($data['password'], $user->password)) {
                $this->logAuthAttempt($data['email'], false, 'Invalid password');
                return $this->apiUnauthorized('Invalid credentials');
            }

            // Generate JWT tokens
            $tokens = $this->jwtService->generateTokens($user);

            $this->logAuthAttempt($data['email'], true, 'Login successful');

            return $this->apiResponse([
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'role' => $user->role,
                ],
                'tokens' => $tokens,
            ], 'Login successful');

        } catch (\Exception $e) {
            $this->logApiError('Login error: ' . $e->getMessage(), 500);
            return $this->apiError('Internal server error', 500);
        }
    }

    /**
     * Logout endpoint
     *
     * @return \Cake\Http\Response
     */
    public function logout(): Response
    {
        if (!$this->request->is('post')) {
            return $this->apiError('Only POST method is allowed', 405);
        }

        // For JWT, logout is primarily handled on the client side
        // by removing the token from storage
        // In a more advanced implementation, we could maintain a blacklist
        // of revoked tokens on the server side

        return $this->apiResponse(null, 'Successfully logged out');
    }

    /**
     * Refresh token endpoint
     *
     * @return \Cake\Http\Response
     */
    public function refresh(): Response
    {
        if (!$this->request->is('post')) {
            return $this->apiError('Only POST method is allowed', 405);
        }

        $data = $this->request->getData();

        if (empty($data['refresh_token'])) {
            return $this->apiValidationError(['refresh_token' => ['Refresh token is required']]);
        }

        try {
            // Validate refresh token
            $payload = $this->jwtService->validateToken($data['refresh_token'], 'refresh');

            if (!$payload) {
                return $this->apiUnauthorized('Invalid refresh token');
            }

            // Find user
            $user = $this->Users->get($payload['sub']);

            if (!$user || !$user->active) {
                return $this->apiUnauthorized('User not found or inactive');
            }

            // Generate new tokens
            $tokens = $this->jwtService->generateTokens($user);

            return $this->apiResponse([
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'role' => $user->role,
                ],
                'tokens' => $tokens,
            ], 'Token refreshed successfully');

        } catch (\Exception $e) {
            $this->logApiError('Token refresh error: ' . $e->getMessage(), 500);
            return $this->apiError('Internal server error', 500);
        }
    }
}
