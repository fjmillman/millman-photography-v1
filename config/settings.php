<?php

return [
    'settings' => [
        'displayErrorDetails' => getenv('ENVIRONMENT') == 'development' ? true : false,
        'plates' => [
            'directory' =>  '../templates/',
            'assetPath' => __DIR__ . '/../public/',
        ],
        'db' => [
            'driver' => getenv('DB_DRIVER'),
            'host' => getenv('DB_HOST'),
            'port' => getenv('DB_PORT'),
            'name' => getenv('DB_NAME'),
            'username' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD'),
            'charset' => getenv('DB_CHARSET'),
            'collation' => getenv('DB_COLLATION'),
        ],
        'logger' => [
            'name' => 'millman-photography',
            'settings' => [
                'path' => 'millman-photography.log',
                'directory' => __DIR__ . '/../logs/',
                'filename' => 'millman-photography.log',
                'timezone' => 'Europe/London',
            ],
        ],
    ]
];
