<?php

require __DIR__ . '/../vendor/autoload.php';

use Slim\App;
use Dotenv\Dotenv;

$dotenv = new Dotenv(realpath(dirname(__DIR__)));
$dotenv->load();

session_start([
    'name' => 'Millman Photography',
    'use_strict_mode' => true,
    'use_only_cookies' => true,
    'gc_maxlifetime' => 60 * 15,
    'cookie_httponly' => true,
]);

$settings = require __DIR__ . '/../config/settings.php';

$millmanphotography = new App($settings);

require __DIR__ . '/../config/dependencies.php';
require __DIR__ . '/../config/middleware.php';
require __DIR__ . '/../config/routes.php';

set_error_handler(function ($severity, $message, $file, $line) {
    throw new ErrorException($message, 0, $severity, $file, $line);
}, E_ALL);

$millmanphotography->run();
