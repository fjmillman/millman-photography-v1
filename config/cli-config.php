<?php declare(strict_types = 1);

use Dotenv\Dotenv;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = new Dotenv(realpath(dirname(__DIR__)));
$dotenv->load();

$settings = require __DIR__ . '/../config/settings.php';
$settings = $settings['settings']['doctrine'];

$config = Setup::createAnnotationMetadataConfiguration(
    $settings['meta']['entity_path'],
    $settings['meta']['auto_generate_proxies'],
    $settings['meta']['proxy_dir'],
    $settings['meta']['cache'],
    false
);

$em = EntityManager::create($settings['connection'], $config);

return ConsoleRunner::createHelperSet($em);
