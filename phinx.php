<?php

use Dotenv\Dotenv;

$dotenv = new Dotenv(realpath(dirname(__DIR__)));
$dotenv->load();

return [
    'paths' => [
        'migrations' => 'migrations'
    ],
    'migration_base_class' => '\MillmanPhotography\Migration\Migration',
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_database' => 'millman_photography',
        'dev' => [
            'adapter' => getenv('DB_DRIVER'),
            'host' => getenv('DB_HOST'),
            'name' => getenv('DB_NAME'),
            'user' => getenv('DB_USERNAME'),
            'pass' => getenv('DB_PASSWORD'),
            'port' => getenv('DB_PORT'),
        ]
    ]
];
