<?php
/**
 * Routes configuration.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * It's loaded within the context of `Application::routes()` method which
 * receives a `RouteBuilder` instance `$routes` as method argument.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

/*
 * This file is loaded in the context of the `Application` class.
 * So you can use `$this` to reference the application class instance
 * if required.
 */
return function (RouteBuilder $routes): void {
    /*
     * The default class to use for all routes
     *
     * The following route classes are supplied with CakePHP and are appropriate
     * to set as the default:
     *
     * - Route
     * - InflectedRoute
     * - DashedRoute
     *
     * If no call is made to `Router::defaultRouteClass()`, the class used is
     * `Route` (`Cake\Routing\Route\Route`)
     *
     * Note that `Route` does not do any inflections on URLs which will result in
     * inconsistently cased URLs when used with `{plugin}`, `{controller}` and
     * `{action}` markers.
     */
    $routes->setRouteClass(DashedRoute::class);

    $routes->scope('/', function (RouteBuilder $builder): void {
        /*
         * Here, we are connecting '/' (base path) to a controller called 'Pages',
         * its action called 'display', and we pass a param to select the view file
         * to use (in this case, templates/Pages/home.php)...
         */
        $builder->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);

        /*
         * Health check endpoints
         */
        $builder->connect('/health', ['controller' => 'Health', 'action' => 'check']);
        $builder->connect('/health/check', ['controller' => 'Health', 'action' => 'check']);
        $builder->connect('/health/database', ['controller' => 'Health', 'action' => 'database']);

        /*
         * ...and connect the rest of 'Pages' controller's URLs.
         */
        $builder->connect('/pages/*', 'Pages::display');

        /*
         * Connect catchall routes for all controllers.
         *
         * The `fallbacks` method is a shortcut for
         *
         * ```
         * $builder->connect('/{controller}', ['action' => 'index']);
         * $builder->connect('/{controller}/{action}/*', []);
         * ```
         *
         * It is NOT recommended to use fallback routes after your initial prototyping phase!
         * See https://book.cakephp.org/5/en/development/routing.html#fallbacks-method for more information
         */
        $builder->fallbacks();
    });

    /*
     * API Routes
     */
    $routes->prefix('api', function (RouteBuilder $builder): void {
        // Set JSON extension for API routes
        $builder->setExtensions(['json']);
        
        // API v1 routes
        $builder->scope('/v1', function (RouteBuilder $builder): void {
            // Health check endpoints
            $builder->connect('/health', ['controller' => 'Health', 'action' => 'check']);
            $builder->connect('/health/database', ['controller' => 'Health', 'action' => 'database']);
            
            // Authentication endpoints
            $builder->connect('/auth/login', ['controller' => 'Auth', 'action' => 'login']);
            $builder->connect('/auth/logout', ['controller' => 'Auth', 'action' => 'logout']);
            $builder->connect('/auth/refresh', ['controller' => 'Auth', 'action' => 'refresh']);
            
            // Test endpoints
            $builder->connect('/test/protected', ['controller' => 'Test', 'action' => 'protected']);
            
            // Staff endpoints
            $builder->connect('/staff', ['controller' => 'Staff', 'action' => 'index'], ['_method' => 'GET']);
            $builder->connect('/staff', ['controller' => 'Staff', 'action' => 'add'], ['_method' => 'POST']);
            $builder->connect('/staff/{id}', ['controller' => 'Staff', 'action' => 'view'], ['_method' => 'GET', 'pass' => ['id']]);
            $builder->connect('/staff/{id}', ['controller' => 'Staff', 'action' => 'edit'], ['_method' => ['PUT', 'PATCH'], 'pass' => ['id']]);
            $builder->connect('/staff/{id}', ['controller' => 'Staff', 'action' => 'delete'], ['_method' => 'DELETE', 'pass' => ['id']]);
            
            // Future API endpoints will be added here
            // $builder->connect('/clients', ['controller' => 'Clients', 'action' => 'index']);
            // $builder->connect('/projects', ['controller' => 'Projects', 'action' => 'index']);
        });
    });
};
