<?php

return [
    'settings' => [
        'displayErrorDetails' => true,
        'addContentLengthHeader' => true,
        'db' => [
            'host' => getenv('DB_HOST'),
            'name' => getenv('DB_NAME'),
            'char' => getenv('DB_CHAR'),
            'user' => getenv('DB_USER'),
            'pass' => getenv('DB_PASS'),
        ]
    ],
];
