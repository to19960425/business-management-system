<?php

use Cake\Cache\Engine\FileEngine;
use Cake\Database\Connection;
use Cake\Database\Driver\Mysql;
use Cake\Log\Engine\FileLog;
use Cake\Mailer\Transport\MailTransport;

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
    'debug' => filter_var(env('DEBUG', false), FILTER_VALIDATE_BOOLEAN),

    /*
     * Configure basic information about the application.
     *
     * - namespace - The namespace to find app classes under.
     * - defaultLocale - The default locale for translation, formatting currencies and numbers, date and time.
     * - encoding - The encoding used for HTML + database connections.
     * - base - The base directory the app resides in. If false this
     *   will be auto-detected.
     * - dir - Name of app directory.
     * - webroot - The webroot directory.
     * - wwwRoot - The file path to webroot.
     * - baseUrl - To configure CakePHP to *not* use mod_rewrite and to
     *   use CakePHP pretty URLs, remove these .htaccess
     *   files:
     *      /.htaccess
     *      /webroot/.htaccess
     *   And uncomment the baseUrl key below.
     * - fullBaseUrl - A base URL to use for absolute links. When set to false (default)
     *   CakePHP generates required value based on `HTTP_HOST` environment variable.
     *   However, you can define it manually to optimize performance or if you
     *   are concerned about people manipulating the `Host` header.
     * - imageBaseUrl - Web path to the public images/ directory under webroot.
     * - cssBaseUrl - Web path to the public css/ directory under webroot.
     * - jsBaseUrl - Web path to the public js/ directory under webroot.
     * - paths - Configure paths for non class-based resources. Supports the
     *   `plugins`, `templates`, `locales` subkeys, which allow the definition of
     *   paths for plugins, view templates and locale files respectively.
     */
    'App' => [
        'namespace' => 'App',
        'encoding' => env('APP_ENCODING', 'UTF-8'),
        'defaultLocale' => env('APP_DEFAULT_LOCALE', 'en_US'),
        'defaultTimezone' => env('APP_DEFAULT_TIMEZONE', 'UTC'),
        'base' => false,
        'dir' => 'src',
        'webroot' => 'webroot',
        'wwwRoot' => WWW_ROOT,
        //'baseUrl' => env('SCRIPT_NAME'),
        'fullBaseUrl' => false,
        'imageBaseUrl' => 'img/',
        'cssBaseUrl' => 'css/',
        'jsBaseUrl' => 'js/',
        'paths' => [
            'plugins' => [ROOT . DS . 'plugins' . DS],
            'templates' => [ROOT . DS . 'templates' . DS],
            'locales' => [RESOURCES . 'locales' . DS],
        ],
    ],

    /*
     * Security and encryption configuration
     *
     * - salt - A random string used in security hashing methods.
     *   The salt value is also used as the encryption key.
     *   You should treat it as extremely sensitive data.
     */
    'Security' => [
        'salt' => env('SECURITY_SALT'),
    ],

    /*
     * Apply timestamps with the last modified time to static assets (js, css, images).
     * Will append a querystring parameter containing the time the file was modified.
     * This is useful for busting browser caches.
     *
     * Set to true to apply timestamps when debug is true. Set to 'force' to always
     * enable timestamping regardless of debug value.
     */
    'Asset' => [
        //'timestamp' => true,
        // 'cacheTime' => '+1 year'
    ],

    /*
     * Configure the cache adapters.
     */
    'Cache' => [
        'default' => [
            'className' => FileEngine::class,
            'path' => CACHE,
            'url' => env('CACHE_DEFAULT_URL', null),
        ],

        /*
         * Configure the cache used for general framework caching.
         * Translation cache files are stored with this configuration.
         * Duration will be set to '+2 minutes' in bootstrap.php when debug = true
         * If you set 'className' => 'Null' core cache will be disabled.
         */
        '_cake_translations_' => [
            'className' => FileEngine::class,
            'prefix' => 'myapp_cake_translations_',
            'path' => CACHE . 'persistent' . DS,
            'serialize' => true,
            'duration' => '+1 years',
            'url' => env('CACHE_CAKECORE_URL', null),
        ],

        /*
         * Configure the cache for model and datasource caches. This cache
         * configuration is used to store schema descriptions, and table listings
         * in connections.
         * Duration will be set to '+2 minutes' in bootstrap.php when debug = true
         */
        '_cake_model_' => [
            'className' => FileEngine::class,
            'prefix' => 'myapp_cake_model_',
            'path' => CACHE . 'models' . DS,
            'serialize' => true,
            'duration' => '+1 years',
            'url' => env('CACHE_CAKEMODEL_URL', null),
        ],
    ],

    /*
     * Configure the Error and Exception handlers used by your application.
     *
     * By default errors are displayed using Debugger, when debug is true and logged
     * by Cake\Log\Log when debug is false.
     *
     * In CLI environments exceptions will be printed to stderr with a backtrace.
     * In web environments an HTML page will be displayed for the exception.
     * With debug true, framework errors like Missing Controller will be displayed.
     * When debug is false, framework errors will be coerced into generic HTTP errors.
     *
     * Options:
     *
     * - `errorLevel` - int - The level of errors you are interested in capturing.
     * - `trace` - boolean - Whether backtraces should be included in
     *   logged errors/exceptions.
     * - `log` - boolean - Whether you want exceptions logged.
     * - `exceptionRenderer` - string - The class responsible for rendering uncaught exceptions.
     *   The chosen class will be used for both CLI and web environments. If you want different
     *   classes used in CLI and web environments you'll need to write that conditional logic as well.
     *   The conventional location for custom renderers is in `src/Error`. Your exception renderer needs to
     *   implement the `render()` method and return either a string or Http\Response.
     *   `errorRenderer` - string - The class responsible for rendering PHP errors. The selected
     *   class will be used for both web and CLI contexts. If you want different classes for each environment
     *   you'll need to write that conditional logic as well. Error renderers need to
     *   to implement the `Cake\Error\ErrorRendererInterface`.
     * - `skipLog` - array - List of exceptions to skip for logging. Exceptions that
     *   extend one of the listed exceptions will also be skipped for logging.
     *   E.g.:
     *   `'skipLog' => ['Cake\Http\Exception\NotFoundException', 'Cake\Http\Exception\UnauthorizedException']`
     * - `extraFatalErrorMemory` - int - The number of megabytes to increase the memory limit by
     *   when a fatal error is encountered. This allows
     *   breathing room to complete logging or error handling.
     * - `ignoredDeprecationPaths` - array - A list of glob-compatible file paths that deprecations
     *   should be ignored in. Use this to ignore deprecations for plugins or parts of
     *   your application that still emit deprecations.
     */
    'Error' => [
        'errorLevel' => E_ALL,
        'skipLog' => [],
        'log' => true,
        'trace' => true,
        'ignoredDeprecationPaths' => [],
    ],

    /*
     * Debugger configuration
     *
     * Define development error values for Cake\Error\Debugger
     *
     * - `editor` Set the editor URL format you want to use.
     *   By default atom, emacs, macvim, phpstorm, sublime, textmate, and vscode are
     *   available. You can add additional editor link formats using
     *   `Debugger::addEditor()` during your application bootstrap.
     * - `outputMask` A mapping of `key` to `replacement` values that
     *   `Debugger` should replace in dumped data and logs generated by `Debugger`.
     */
    'Debugger' => [
        'editor' => 'phpstorm',
    ],

    /*
     * Email configuration.
     *
     * By defining transports separately from delivery profiles you can easily
     * re-use transport configuration across multiple profiles.
     *
     * You can specify multiple configurations for production, development and
     * testing.
     *
     * Each transport needs a `className`. Valid options are as follows:
     *
     *  Mail   - Send using PHP mail function
     *  Smtp   - Send using SMTP
     *  Debug  - Do not send the email, just return the result
     *
     * You can add custom transports (or override existing transports) by adding the
     * appropriate file to src/Mailer/Transport. Transports should be named
     * 'YourTransport.php', where 'Your' is the name of the transport.
     */
    'EmailTransport' => [
        'default' => [
            'className' => MailTransport::class,
            /*
             * The keys host, port, timeout, username, password, client and tls
             * are used in SMTP transports
             */
            'host' => 'localhost',
            'port' => 25,
            'timeout' => 30,
            /*
             * It is recommended to set these options through your environment or app_local.php
             */
            //'username' => null,
            //'password' => null,
            'client' => null,
            'tls' => false,
            'url' => env('EMAIL_TRANSPORT_DEFAULT_URL', null),
        ],
    ],

    /*
     * Email delivery profiles
     *
     * Delivery profiles allow you to predefine various properties about email
     * messages from your application and give the settings a name. This saves
     * duplication across your application and makes maintenance and development
     * easier. Each profile accepts a number of keys. See `Cake\Mailer\Mailer`
     * for more information.
     */
    'Email' => [
        'default' => [
            'transport' => 'default',
            'from' => 'you@localhost',
            /*
             * Will by default be set to config value of App.encoding, if that exists otherwise to UTF-8.
             */
            //'charset' => 'utf-8',
            //'headerCharset' => 'utf-8',
        ],
    ],

    /*
     * Connection information used by the ORM to connect
     * to your application's datastores.
     *
     * ### Notes
     * - Drivers include Mysql Postgres Sqlite Sqlserver
     *   See vendor\cakephp\cakephp\src\Database\Driver for the complete list
     * - Do not use periods in database name - it may lead to errors.
     *   See https://github.com/cakephp/cakephp/issues/6471 for details.
     * - 'encoding' is recommended to be set to full UTF-8 4-Byte support.
     *   E.g set it to 'utf8mb4' in MariaDB and MySQL and 'utf8' for any
     *   other RDBMS.
     */
    'Datasources' => [
        /*
         * These configurations should contain permanent settings used
         * by all environments.
         *
         * The values in app_local.php will override any values set here
         * and should be used for local and per-environment configurations.
         *
         * Environment variable-based configurations can be loaded here or
         * in app_local.php depending on the application's needs.
         */
        'default' => [
            'className' => Connection::class,
            'driver' => Mysql::class,
            'persistent' => false,
            'timezone' => 'UTC',

            /*
             * For MariaDB/MySQL the internal default changed from utf8 to utf8mb4, aka full utf-8 support
             */
            'encoding' => 'utf8mb4',

            /*
             * If your MySQL server is configured with `skip-character-set-client-handshake`
             * then you MUST use the `flags` config to set your charset encoding.
             * For e.g. `'flags' => [\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4']`
             */
            'flags' => [],
            'cacheMetadata' => true,
            'log' => env('DB_LOG_QUERIES', false),
            
            /*
             * Connection pool and performance settings
             */
            'persistent' => env('DB_PERSISTENT', false),
            'reconnect' => true,
            'init' => [
                'SET SESSION sql_mode = "TRADITIONAL"',
                'SET SESSION wait_timeout = 300',
                'SET SESSION interactive_timeout = 300',
            ],

            /*
             * Set identifier quoting to true if you are using reserved words or
             * special characters in your table or column names. Enabling this
             * setting will result in queries built using the Query Builder having
             * identifiers quoted when creating SQL. It should be noted that this
             * decreases performance because each query needs to be traversed and
             * manipulated before being executed.
             */
            'quoteIdentifiers' => false,

            /*
             * During development, if using MySQL < 5.6, uncommenting the
             * following line could boost the speed at which schema metadata is
             * fetched from the database. It can also be set directly with the
             * mysql configuration directive 'innodb_stats_on_metadata = 0'
             * which is the recommended value in production environments
             */
            //'init' => ['SET GLOBAL innodb_stats_on_metadata = 0'],
        ],

        /*
         * The test connection is used during the test suite.
         */
        'test' => [
            'className' => Connection::class,
            'driver' => Mysql::class,
            'persistent' => false,
            'timezone' => 'UTC',
            'encoding' => 'utf8mb4',
            'flags' => [],
            'cacheMetadata' => true,
            'quoteIdentifiers' => false,
            'log' => false,
            //'init' => ['SET GLOBAL innodb_stats_on_metadata = 0'],
        ],
    ],

    /*
     * Configures logging options
     */
    'Log' => [
        'debug' => [
            'className' => FileLog::class,
            'path' => LOGS,
            'file' => 'debug',
            'url' => env('LOG_DEBUG_URL', null),
            'scopes' => null,
            'levels' => ['notice', 'info', 'debug'],
        ],
        'error' => [
            'className' => FileLog::class,
            'path' => LOGS,
            'file' => 'error',
            'url' => env('LOG_ERROR_URL', null),
            'scopes' => null,
            'levels' => ['warning', 'error', 'critical', 'alert', 'emergency'],
        ],
        // To enable this dedicated query log, you need to set your datasource's log flag to true
        'queries' => [
            'className' => FileLog::class,
            'path' => LOGS,
            'file' => 'queries',
            'url' => env('LOG_QUERIES_URL', null),
            'scopes' => ['cake.database.queries'],
        ],
        // API-specific logging for requests, authentication, and errors
        'api' => [
            'className' => FileLog::class,
            'path' => LOGS,
            'file' => 'api',
            'url' => env('LOG_API_URL', null),
            'scopes' => ['api'],
            'levels' => ['notice', 'info', 'debug', 'warning', 'error'],
        ],
        // Authentication and security logging
        'auth' => [
            'className' => FileLog::class,
            'path' => LOGS,
            'file' => 'auth',
            'url' => env('LOG_AUTH_URL', null),
            'scopes' => ['auth'],
            'levels' => ['notice', 'info', 'warning', 'error', 'critical'],
        ],
    ],

    /*
     * Session configuration.
     *
     * Contains an array of settings to use for session configuration. The
     * `defaults` key is used to define a default preset to use for sessions, any
     * settings declared here will override the settings of the default config.
     *
     * ## Options
     *
     * - `cookie` - The name of the cookie to use. Defaults to value set for `session.name` php.ini config.
     *    Avoid using `.` in cookie names, as PHP will drop sessions from cookies with `.` in the name.
     * - `cookiePath` - The url path for which session cookie is set. Maps to the
     *   `session.cookie_path` php.ini config. Defaults to base path of app.
     * - `timeout` - The time in minutes a session can be 'idle'. If no request is received in
     *    this duration, the session will be expired and rotated. Pass 0 to disable idle timeout checks.
     * - `defaults` - The default configuration set to use as a basis for your session.
     *    There are four built-in options: php, cake, cache, database.
     * - `handler` - Can be used to enable a custom session handler. Expects an
     *    array with at least the `engine` key, being the name of the Session engine
     *    class to use for managing the session. CakePHP bundles the `CacheSession`
     *    and `DatabaseSession` engines.
     * - `ini` - An associative array of additional 'session.*` ini values to set.
     *
     * Within the `ini` key, you will likely want to define:
     *
     * - `session.cookie_lifetime` - The number of seconds that cookies are valid for. This
     *    should be longer than `Session.timeout`.
     * - `session.gc_maxlifetime` - The number of seconds after which a session is considered 'garbage'
     *    that can be deleted by PHP's session cleanup behavior. This value should be greater than both
     *    `Sesssion.timeout` and `session.cookie_lifetime`.
     *
     * The built-in `defaults` options are:
     *
     * - 'php' - Uses settings defined in your php.ini.
     * - 'cake' - Saves session files in CakePHP's /tmp directory.
     * - 'database' - Uses CakePHP's database sessions.
     * - 'cache' - Use the Cache class to save sessions.
     *
     * To define a custom session handler, save it at src/Http/Session/<name>.php.
     * Make sure the class implements PHP's `SessionHandlerInterface` and set
     * Session.handler to <name>
     *
     * To use database sessions, load the SQL file located at config/schema/sessions.sql
     */
    'Session' => [
        'defaults' => 'php',
    ],

    /**
     * DebugKit configuration.
     *
     * Contains an array of configurations to apply to the DebugKit plugin, if loaded.
     * Documentation: https://book.cakephp.org/debugkit/5/en/index.html#configuration
     *
     * ## Options
     *
     *  - `panels` - Enable or disable panels. The key is the panel name, and the value is true to enable,
     *     or false to disable.
     *  - `includeSchemaReflection` - Set to true to enable logging of schema reflection queries. Disabled by default.
     *  - `safeTld` - Set an array of whitelisted TLDs for local development.
     *  - `forceEnable` - Force DebugKit to display. Careful with this, it is usually safer to simply whitelist
     *     your local TLDs.
     *  - `ignorePathsPattern` - Regex pattern (including delimiter) to ignore paths.
     *     DebugKit won’t save data for request URLs that match this regex.
     *  - `ignoreAuthorization` - Set to true to ignore Cake Authorization plugin for DebugKit requests.
     *     Disabled by default.
     *  - `maxDepth` - Defines how many levels of nested data should be shown in general for debug output.
     *     Default is 5. WARNING: Increasing the max depth level can lead to an out of memory error.
     *  - `variablesPanelMaxDepth` - Defines how many levels of nested data should be shown in the variables tab.
     *     Default is 5. WARNING: Increasing the max depth level can lead to an out of memory error.
     */
    'DebugKit' => [
        'forceEnable' => filter_var(env('DEBUG_KIT_FORCE_ENABLE', false), FILTER_VALIDATE_BOOLEAN),
        'safeTld' => env('DEBUG_KIT_SAFE_TLD', null),
        'ignoreAuthorization' => env('DEBUG_KIT_IGNORE_AUTHORIZATION', false),
    ],
];
