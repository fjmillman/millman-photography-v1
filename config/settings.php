<?php

return [
    'settings' => [
        'displayErrorDetails' => getenv('ENVIRONMENT') == 'development' ? true : false,
        'plates' => [
            'directory' =>  __DIR__ . '/../templates/',
            'assetPath' => __DIR__ . '/../public/',
        ],
        'doctrine' => [
            'meta' => [
                'entity_path' => [
                    __DIR__ . '/../src/Entity'
                ],
                'auto_generate_proxies' => true,
                'proxy_dir' =>  __DIR__.'/../cache/proxies',
                'cache' => null,
            ],
            'connection' => [
                'driver' => getenv('DB_DRIVER'),
                'host' => getenv('DB_HOST'),
                'dbname' => getenv('DB_NAME'),
                'user' => getenv('DB_USERNAME'),
                'password' => getenv('DB_PASSWORD'),
            ]
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
