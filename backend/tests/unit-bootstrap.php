<?php
declare(strict_types=1);

/**
 * Unit Test bootstrap - without database migrations
 */

use Cake\Chronos\Chronos;
use Cake\Core\Configure;

/**
 * Test runner bootstrap for unit tests.
 */
require dirname(__DIR__) . '/vendor/autoload.php';
require dirname(__DIR__) . '/config/bootstrap.php';

if (empty($_SERVER['HTTP_HOST']) && !Configure::read('App.fullBaseUrl')) {
    Configure::write('App.fullBaseUrl', 'http://localhost');
}

// Fixate now to avoid one-second-leap-issues
Chronos::setTestNow(Chronos::now());

// Fixate sessionid early on
session_id('cli');
