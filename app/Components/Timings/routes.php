<?php

/**
 * @file
 * Маршруты бд времени проведения пары
 */

if (isset($router)) {
    $router->group(
        [
            'prefix'    => '/api/timings',
            'namespace' => '\App\Components\Timings\Controllers'
        ],
        function () use ($router) {
            $router->get('/', ['uses' => 'TimingController@gerRecords']);
            $router->get('/one', ['uses' => 'TimingController@gerRecord']);
        }
    );
}
