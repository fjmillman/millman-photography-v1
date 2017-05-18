<?php

use Monolog\Logger;

return [
    'settings' => [
        'displayErrorDetails' => true,
        'addContentLengthHeader' => true,
        'view' => [
            'directory' => ROOT . DS . 'templates/',
            'assetPath' => PUBLIC_HTML,
        ],
        'db' => [
            'host' => getenv('DB_HOST'),
            'port' => getenv('DB_PORT'),
            'name' => getenv('DB_NAME'),
            'charset' => getenv('DB_CHARSET'),
            'username' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD'),
        ],
        'logger' => [
            'basename' => 'millman-photography',
            'directory' => ROOT . '/logs',
            'filename' => 'millman-photography.log',
            'timezone' => 'Europe/London',
            'level' => Logger::DEBUG,
            'handlers' => [],
        ],
    ]
];
