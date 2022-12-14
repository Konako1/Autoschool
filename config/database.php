<?php

return [
    'default'    => 'prit',
    'migrations' => 'migrations',

    'connections' => [
        'prit' => [
            'driver'    => env('DB_CONNECTION'),
            'host'      => env('DB_HOST'),
            'port'      => env('DB_PORT'),
            'database'  => env('DB_DATABASE'),
            'username'  => env('DB_USERNAME'),
            'password'  => env('DB_PASSWORD'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => true,
        ],
    ],
];
