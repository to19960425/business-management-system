<?php
declare(strict_types=1);

namespace App\Service;

use Cake\Database\Connection;
use Cake\Database\Exception\MissingConnectionException;
use Cake\Datasource\ConnectionManager;
use Cake\Log\Log;
use Exception;
use PDOException;

class DatabaseConnectionService
{
    private const MAX_RETRY_ATTEMPTS = 3;
    private const RETRY_DELAY_SECONDS = 2;
    
    public function testConnection(string $connectionName = 'default'): bool
    {
        try {
            $connection = ConnectionManager::get($connectionName);
            
            if (!$connection instanceof Connection) {
                throw new MissingConnectionException(['name' => $connectionName]);
            }
            
            $connection->connect();
            
            $result = $connection->execute('SELECT 1 as test');
            $testResult = $result->fetch();
            
            return $testResult['test'] === 1;
            
        } catch (Exception $e) {
            Log::error('Database connection test failed: ' . $e->getMessage(), [
                'connection' => $connectionName,
                'exception' => get_class($e),
                'trace' => $e->getTraceAsString()
            ]);
            
            return false;
        }
    }
    
    public function getConnectionWithRetry(string $connectionName = 'default'): ?Connection
    {
        $attempts = 0;
        
        while ($attempts < self::MAX_RETRY_ATTEMPTS) {
            try {
                $connection = ConnectionManager::get($connectionName);
                
                if (!$connection instanceof Connection) {
                    throw new MissingConnectionException(['name' => $connectionName]);
                }
                
                $connection->connect();
                
                return $connection;
                
            } catch (PDOException $e) {
                $attempts++;
                
                Log::warning("Database connection attempt {$attempts} failed: " . $e->getMessage(), [
                    'connection' => $connectionName,
                    'attempt' => $attempts,
                    'max_attempts' => self::MAX_RETRY_ATTEMPTS
                ]);
                
                if ($attempts < self::MAX_RETRY_ATTEMPTS) {
                    sleep(self::RETRY_DELAY_SECONDS);
                }
            } catch (Exception $e) {
                Log::error('Database connection failed with non-recoverable error: ' . $e->getMessage(), [
                    'connection' => $connectionName,
                    'exception' => get_class($e),
                    'trace' => $e->getTraceAsString()
                ]);
                
                break;
            }
        }
        
        return null;
    }
    
    public function validateConnectionConfig(string $connectionName = 'default'): array
    {
        $config = ConnectionManager::getConfig($connectionName);
        $issues = [];
        
        if (!$config) {
            $issues[] = "Connection configuration '{$connectionName}' not found";
            return $issues;
        }
        
        $requiredFields = ['host', 'username', 'database'];
        foreach ($requiredFields as $field) {
            if (empty($config[$field])) {
                $issues[] = "Missing required field: {$field}";
            }
        }
        
        if (!empty($config['port']) && !is_numeric($config['port'])) {
            $issues[] = "Port must be numeric";
        }
        
        if (!empty($config['flags']) && !is_array($config['flags'])) {
            $issues[] = "Flags must be an array";
        }
        
        return $issues;
    }
    
    public function getConnectionStatus(string $connectionName = 'default'): array
    {
        $status = [
            'connection' => $connectionName,
            'connected' => false,
            'config_valid' => false,
            'server_info' => null,
            'issues' => []
        ];
        
        $configIssues = $this->validateConnectionConfig($connectionName);
        if (!empty($configIssues)) {
            $status['issues'] = $configIssues;
            return $status;
        }
        
        $status['config_valid'] = true;
        
        try {
            $connection = ConnectionManager::get($connectionName);
            
            if (!$connection instanceof Connection) {
                $status['issues'][] = "Invalid connection type";
                return $status;
            }
            
            $connection->connect();
            $status['connected'] = true;
            
            $serverInfo = $connection->execute('SELECT VERSION() as version, CONNECTION_ID() as connection_id');
            $info = $serverInfo->fetch();
            
            $status['server_info'] = [
                'version' => $info['version'],
                'connection_id' => $info['connection_id']
            ];
            
        } catch (Exception $e) {
            $status['issues'][] = $e->getMessage();
        }
        
        return $status;
    }
    
    public function closeConnection(string $connectionName = 'default'): bool
    {
        try {
            $connection = ConnectionManager::get($connectionName);
            
            if ($connection instanceof Connection) {
                $connection->disconnect();
                return true;
            }
            
            return false;
            
        } catch (Exception $e) {
            Log::error('Failed to close database connection: ' . $e->getMessage(), [
                'connection' => $connectionName
            ]);
            
            return false;
        }
    }
}