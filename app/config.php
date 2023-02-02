<?php

return [
    'settings' => [
        'db'  => [
            'driver'   => $_ENV['DB_DRIVER'],
            'host'     => $_ENV['DB_HOST'],
            'port'     => $_ENV['DB_PORT'],
            'database' => $_ENV['DB_DATABASE'],
            'user'     => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASSWORD'],
        ],
        'log' => [
            'path' => $_ENV['LOG_PATH'],
        ],
    ],
];
