<?php
declare(strict_types=1);

namespace App\Test\TestCase\Service;

use App\Service\DatabaseConnectionService;
use Cake\Database\Connection;
use Cake\Datasource\ConnectionManager;
use Cake\TestSuite\TestCase;

class DatabaseConnectionServiceTest extends TestCase
{
    private DatabaseConnectionService $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = new DatabaseConnectionService();
    }

    public function testTestConnectionSuccess(): void
    {
        $result = $this->service->testConnection('test');

        $this->assertTrue($result);
    }

    public function testTestConnectionFailure(): void
    {
        $result = $this->service->testConnection('nonexistent');

        $this->assertFalse($result);
    }

    public function testGetConnectionWithRetrySuccess(): void
    {
        $connection = $this->service->getConnectionWithRetry('test');

        $this->assertInstanceOf(Connection::class, $connection);
    }

    public function testGetConnectionWithRetryFailure(): void
    {
        $connection = $this->service->getConnectionWithRetry('nonexistent');

        $this->assertNull($connection);
    }

    public function testValidateConnectionConfigSuccess(): void
    {
        $issues = $this->service->validateConnectionConfig('test');

        $this->assertEmpty($issues);
    }

    public function testValidateConnectionConfigFailure(): void
    {
        ConnectionManager::setConfig('invalid_config', [
            'host' => '',
            'username' => '',
            'database' => '',
        ]);

        $issues = $this->service->validateConnectionConfig('invalid_config');

        $this->assertNotEmpty($issues);
        $this->assertContains('Missing required field: host', $issues);
        $this->assertContains('Missing required field: username', $issues);
        $this->assertContains('Missing required field: database', $issues);

        ConnectionManager::drop('invalid_config');
    }

    public function testValidateConnectionConfigNonexistent(): void
    {
        $issues = $this->service->validateConnectionConfig('nonexistent');

        $this->assertNotEmpty($issues);
        $this->assertContains("Connection configuration 'nonexistent' not found", $issues);
    }

    public function testGetConnectionStatusSuccess(): void
    {
        $status = $this->service->getConnectionStatus('test');

        $this->assertIsArray($status);
        $this->assertArrayHasKey('connection', $status);
        $this->assertArrayHasKey('connected', $status);
        $this->assertArrayHasKey('config_valid', $status);
        $this->assertArrayHasKey('server_info', $status);
        $this->assertArrayHasKey('issues', $status);

        $this->assertEquals('test', $status['connection']);
        $this->assertTrue($status['config_valid']);
        $this->assertEmpty($status['issues']);
    }

    public function testGetConnectionStatusFailure(): void
    {
        $status = $this->service->getConnectionStatus('nonexistent');

        $this->assertIsArray($status);
        $this->assertEquals('nonexistent', $status['connection']);
        $this->assertFalse($status['config_valid']);
        $this->assertNotEmpty($status['issues']);
    }

    public function testCloseConnectionSuccess(): void
    {
        $result = $this->service->closeConnection('test');

        $this->assertTrue($result);
    }

    public function testCloseConnectionFailure(): void
    {
        $result = $this->service->closeConnection('nonexistent');

        $this->assertFalse($result);
    }
}
