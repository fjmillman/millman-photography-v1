<?php declare(strict_types = 1);

require __DIR__ . '/../vendor/autoload.php';

use Slim\App;
use Dotenv\Dotenv;

if (PHP_SAPI === 'cli-server') {
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

$dotenv = new Dotenv(realpath(dirname(__DIR__)));
$dotenv->load();

session_start([
    'name' => 'MillmanPhotography',
    'use_strict_mode' => true,
    'use_only_cookies' => true,
    'gc_maxlifetime' => 60 * 15,
    'cookie_lifetime' => 0,
    'cookie_httponly' => true,
    'sid_length' => 64,
    'sid_bits_per_character' => 6,
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
