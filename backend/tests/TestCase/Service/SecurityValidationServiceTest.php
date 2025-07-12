<?php
declare(strict_types=1);

namespace App\Test\TestCase\Service;

use App\Service\SecurityValidationService;
use Cake\Core\Configure;
use Cake\TestSuite\TestCase;
use RuntimeException;

/**
 * SecurityValidationService Test Case
 */
class SecurityValidationServiceTest extends TestCase
{
    protected SecurityValidationService $service;

    /**
     * setUp method
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->service = new SecurityValidationService();
    }

    /**
     * tearDown method
     */
    public function tearDown(): void
    {
        unset($this->service);
        parent::tearDown();
    }

    /**
     * Test validateConfiguration with default JWT secret
     */
    public function testValidateConfigurationWithDefaultJwtSecret(): void
    {
        Configure::write('JWT.secret', 'your-super-secret-jwt-key-here');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('JWT_SECRET must be changed from default value');

        $this->service->validateConfiguration();
    }

    /**
     * Test validateConfiguration with default security salt
     */
    public function testValidateConfigurationWithDefaultSecuritySalt(): void
    {
        Configure::write('JWT.secret', 'a-valid-secret-key-that-is-long-enough-for-security');
        Configure::write('Security.salt', '96b31ee9753de2bd08be0f4818cf24ca776e8c4dab095ef8fc68a7f75c548fcc');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('SECURITY_SALT must be changed from default value');

        $this->service->validateConfiguration();
    }

    /**
     * Test validateConfiguration with valid configuration
     */
    public function testValidateConfigurationWithValidSettings(): void
    {
        Configure::write('JWT.secret', 'a-proper-secret-key-that-is-not-default');
        Configure::write('Security.salt', 'a-proper-salt-that-is-not-default-value-here');

        $result = $this->service->validateConfiguration();

        $this->assertTrue($result);
    }

    /**
     * Test validateConfiguration with empty JWT secret
     */
    public function testValidateConfigurationWithEmptyJwtSecret(): void
    {
        Configure::write('JWT.secret', '');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('JWT_SECRET must be configured');

        $this->service->validateConfiguration();
    }

    /**
     * Test validateConfiguration with empty security salt
     */
    public function testValidateConfigurationWithEmptySecuritySalt(): void
    {
        Configure::write('JWT.secret', 'a-valid-secret-key-that-is-long-enough-for-security');
        Configure::write('Security.salt', '');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('SECURITY_SALT must be configured');

        $this->service->validateConfiguration();
    }

    /**
     * Test validateConfiguration with short JWT secret
     */
    public function testValidateConfigurationWithShortJwtSecret(): void
    {
        Configure::write('JWT.secret', 'short');
        Configure::write('Security.salt', 'a-proper-salt-that-is-not-default-value-here');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('JWT_SECRET must be at least 32 characters long');

        $this->service->validateConfiguration();
    }

    /**
     * Test validateConfiguration with short security salt
     */
    public function testValidateConfigurationWithShortSecuritySalt(): void
    {
        Configure::write('JWT.secret', 'a-proper-secret-key-that-is-not-default');
        Configure::write('Security.salt', 'short');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('SECURITY_SALT must be at least 32 characters long');

        $this->service->validateConfiguration();
    }
}
