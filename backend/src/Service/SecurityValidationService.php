<?php
declare(strict_types=1);

namespace App\Service;

use Cake\Core\Configure;
use RuntimeException;

/**
 * Security Validation Service
 *
 * Validates security configuration settings to prevent common vulnerabilities
 */
class SecurityValidationService
{
    /**
     * Default values that should not be used in production
     */
    private const DEFAULT_JWT_SECRET = 'your-super-secret-jwt-key-here';
    private const DEFAULT_SECURITY_SALT = '96b31ee9753de2bd08be0f4818cf24ca776e8c4dab095ef8fc68a7f75c548fcc';
    private const MIN_SECRET_LENGTH = 32;

    /**
     * Validate security configuration
     *
     * @return bool True if configuration is valid
     * @throws \RuntimeException If configuration has security issues
     */
    public function validateConfiguration(): bool
    {
        $this->validateJwtSecret();
        $this->validateSecuritySalt();

        return true;
    }

    /**
     * Validate JWT secret configuration
     *
     * @throws \RuntimeException If JWT secret is invalid
     */
    private function validateJwtSecret(): void
    {
        // Try to get from Configure first, then fallback to env()
        $jwtSecret = Configure::read('JWT.secret');
        if (empty($jwtSecret)) {
            $jwtSecret = env('JWT_SECRET');
        }

        if (empty($jwtSecret)) {
            throw new RuntimeException('JWT_SECRET must be configured');
        }

        if ($jwtSecret === self::DEFAULT_JWT_SECRET) {
            throw new RuntimeException('JWT_SECRET must be changed from default value');
        }

        if (strlen($jwtSecret) < self::MIN_SECRET_LENGTH) {
            throw new RuntimeException('JWT_SECRET must be at least ' . self::MIN_SECRET_LENGTH . ' characters long');
        }
    }

    /**
     * Validate security salt configuration
     *
     * @throws \RuntimeException If security salt is invalid
     */
    private function validateSecuritySalt(): void
    {
        // Try to get from Configure first, then fallback to env()
        $securitySalt = Configure::read('Security.salt');
        if (empty($securitySalt)) {
            $securitySalt = env('SECURITY_SALT');
        }

        if (empty($securitySalt)) {
            throw new RuntimeException('SECURITY_SALT must be configured');
        }

        if ($securitySalt === self::DEFAULT_SECURITY_SALT) {
            throw new RuntimeException('SECURITY_SALT must be changed from default value');
        }

        if (strlen($securitySalt) < self::MIN_SECRET_LENGTH) {
            throw new RuntimeException('SECURITY_SALT must be at least ' . self::MIN_SECRET_LENGTH . ' characters long');
        }
    }
}
