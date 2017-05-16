<?php declare(strict_types = 1);

use Slim\App;
use Dotenv\Dotenv;

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__DIR__)));
define('PUBLIC_HTML', ROOT . DS . 'public' . DS);
define('CONFIG', ROOT . DS . 'config' . DS);
define('SRC', ROOT . DS . 'src' . DS);
define('VENDOR', ROOT . DS . 'vendor' . DS);

require VENDOR . 'autoload.php';

$dotenv = new Dotenv(ROOT);
$dotenv->load();

$settings = require CONFIG . '/settings.php';

$millmanphotography = new App($settings);

require CONFIG . '/dependencies.php';
require CONFIG . '/middleware.php';
require CONFIG . '/routes.php';

set_error_handler(function ($severity, $message, $file, $line) {
    throw new ErrorException($message, 0, $severity, $file, $line);
}, E_ALL);

$millmanphotography->run();
