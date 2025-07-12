<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\Entity\User;
use Cake\Core\Configure;
use Exception;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;

/**
 * JWT Service
 *
 * Handles JWT token generation, validation, and management
 */
class JwtService
{
    /**
     * Generate a JWT token for the given user
     *
     * @param \App\Model\Entity\User $user The user to generate token for
     * @return array Contains access_token, refresh_token, expires_in
     */
    public function generateTokens(User $user): array
    {
        $secret = Configure::read('JWT.secret');
        $algorithm = Configure::read('JWT.algorithm');
        $expiration = Configure::read('JWT.expiration');
        $refreshExpiration = Configure::read('JWT.refresh_expiration');

        $issuedAt = time();
        $accessExpiry = $issuedAt + $expiration;
        $refreshExpiry = $issuedAt + $refreshExpiration;

        // Access token payload
        $accessPayload = [
            'iss' => 'business-management-system',
            'aud' => 'business-management-system',
            'iat' => $issuedAt,
            'exp' => $accessExpiry,
            'sub' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'role' => $user->role,
            'type' => 'access',
        ];

        // Refresh token payload
        $refreshPayload = [
            'iss' => 'business-management-system',
            'aud' => 'business-management-system',
            'iat' => $issuedAt,
            'exp' => $refreshExpiry,
            'sub' => $user->id,
            'type' => 'refresh',
        ];

        $accessToken = JWT::encode($accessPayload, $secret, $algorithm);
        $refreshToken = JWT::encode($refreshPayload, $secret, $algorithm);

        return [
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
            'token_type' => 'Bearer',
            'expires_in' => $expiration,
            'refresh_expires_in' => $refreshExpiration,
        ];
    }

    /**
     * Validate and decode a JWT token
     *
     * @param string $token The JWT token to validate
     * @param string $type Token type ('access' or 'refresh')
     * @return array|null Decoded token payload or null if invalid
     */
    public function validateToken(string $token, string $type = 'access'): ?array
    {
        try {
            $secret = Configure::read('JWT.secret');
            $algorithm = Configure::read('JWT.algorithm');

            $decoded = JWT::decode($token, new Key($secret, $algorithm));
            $payload = (array)$decoded;

            // Verify token type
            if (isset($payload['type']) && $payload['type'] !== $type) {
                return null;
            }

            return $payload;
        } catch (ExpiredException $e) {
            return null;
        } catch (SignatureInvalidException $e) {
            return null;
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Extract user ID from token
     *
     * @param string $token The JWT token
     * @return int|null User ID or null if invalid
     */
    public function getUserIdFromToken(string $token): ?int
    {
        $payload = $this->validateToken($token);

        return $payload['sub'] ?? null;
    }

    /**
     * Check if token is expired
     *
     * @param string $token The JWT token
     * @return bool True if expired, false otherwise
     */
    public function isTokenExpired(string $token): bool
    {
        try {
            $secret = Configure::read('JWT.secret');
            $algorithm = Configure::read('JWT.algorithm');

            JWT::decode($token, new Key($secret, $algorithm));

            return false;
        } catch (ExpiredException $e) {
            return true;
        } catch (Exception $e) {
            return true;
        }
    }

    /**
     * Refresh access token using refresh token
     *
     * @param string $refreshToken The refresh token
     * @param \App\Model\Entity\User $user The user to generate new token for
     * @return array|null New token data or null if invalid
     */
    public function refreshAccessToken(string $refreshToken, User $user): ?array
    {
        $payload = $this->validateToken($refreshToken, 'refresh');

        if (!$payload || $payload['sub'] !== $user->id) {
            return null;
        }

        // Generate new access token
        return $this->generateTokens($user);
    }
}
