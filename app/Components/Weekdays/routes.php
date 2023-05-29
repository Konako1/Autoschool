<?php

/**
 * @file
 * Маршруты бд дней недели
 */

if (isset($router)) {
    $router->group(
        [
            'prefix'    => '/api/weekdays',
            'namespace' => '\App\Components\Weekdays\Controllers'
        ],
        function () use ($router) {
            $router->get('/', ['uses' => 'WeekdayController@gerRecords']);
            $router->get('/one', ['uses' => 'WeekdayController@gerRecord']);
        }
    );
}
