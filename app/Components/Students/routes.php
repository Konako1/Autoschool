<?php

/**
 * @file
 * Маршруты бд студентов
 */

if (isset($router)) {
    $router->group(
        [
            'prefix'    => '/api/students',
            'namespace' => '\App\Components\Students\Controllers'
        ],
        function () use ($router) {
            $router->get('/', ['uses' => 'StudentController@baseGet']);
            $router->get('/one', ['uses' => 'StudentController@getRecord']);
            $router->get('/create', ['uses' => 'StudentController@createRecord']);
            $router->get('/update', ['uses' => 'StudentController@updateRecord']);
            $router->get('/delete', ['uses' => 'StudentController@deleteRecord']);
        }
    );
}
