<?php
/*
 * Local configuration file to provide any overrides to your app.php configuration.
 * Copy and save this file as app_local.php and make changes as required.
 * Note: It is not recommended to commit files with credentials such as app_local.php
 * into source code version control.
 */
return [
    /*
     * Debug Level:
     *
     * Production Mode:
     * false: No error messages, errors, or warnings shown.
     *
     * Development Mode:
     * true: Errors and warnings shown.
     */
    'debug' => filter_var(env('DEBUG', true), FILTER_VALIDATE_BOOLEAN),

    /*
     * Security and encryption configuration
     *
     * - salt - A random string used in security hashing methods.
     *   The salt value is also used as the encryption key.
     *   You should treat it as extremely sensitive data.
     */
    'Security' => [
        'salt' => env('SECURITY_SALT', '96b31ee9753de2bd08be0f4818cf24ca776e8c4dab095ef8fc68a7f75c548fcc'),
    ],

    /*
     * JWT Authentication configuration
     */
    'JWT' => [
        'secret' => env('JWT_SECRET', 'your-super-secret-jwt-key-here'),
        'algorithm' => env('JWT_ALGORITHM', 'HS256'),
        'expiration' => env('JWT_EXPIRATION', 3600),
        'refresh_expiration' => env('JWT_REFRESH_EXPIRATION', 604800),
    ],

    /*
     * Connection information used by the ORM to connect
     * to your application's datastores.
     *
     * See app.php for more configuration options.
     */
    'Datasources' => [
        'default' => [
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', 3306),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'database' => env('DB_NAME', 'business_management'),
            
            /*
             * Connection pool configuration
             */
            'persistent' => env('DB_PERSISTENT', false),
            'init' => [
                'SET SESSION wait_timeout = 300',
                'SET SESSION interactive_timeout = 300',
            ],
            
            /*
             * Connection options for better performance and reliability
             */
            'flags' => [
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci',
                PDO::ATTR_TIMEOUT => 30,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ],
            
            /*
             * You can use a DSN string to set the entire configuration
             */
            'url' => env('DATABASE_URL', null),
        ],

        /*
         * The test connection is used during the test suite.
         */
        'test' => [
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_EXTERNAL_PORT', 3307),
            'username' => env('DB_USERNAME', 'bmuser'),
            'password' => env('DB_PASSWORD', 'bmpass'),
            'database' => env('DB_TEST_NAME', 'test_business_management'),
            'url' => env('DATABASE_TEST_URL', null),
        ],
    ],

    /*
     * Email configuration.
     *
     * Host and credential configuration in case you are using SmtpTransport
     *
     * See app.php for more configuration options.
     */
    'EmailTransport' => [
        'default' => [
            'host' => 'localhost',
            'port' => 25,
            'username' => null,
            'password' => null,
            'client' => null,
            'url' => env('EMAIL_TRANSPORT_DEFAULT_URL', null),
        ],
    ],
];
