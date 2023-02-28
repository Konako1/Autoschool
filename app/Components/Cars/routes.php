<?php

/**
 * @file
 * Маршруты бд модулей предметов
 */

use App\Components\Cars\Controllers\CarController;

if (isset($router)) {
    $router->group(
        [
            'prefix' => '/api/cars',
            'namespace' => 'App\Components\Cars\Controllers'
        ],
        function () use ($router) {
            $router->get('/',           ['uses' => 'CarController@baseGet']);
            $router->get('/one',        ['uses' => 'CarController@getRecord']);
            $router->get('/create',    ['uses' => 'CarController@createRecord']);
            $router->get('/update',    ['uses' => 'CarController@updateRecord']);
            $router->get('/delete',    ['uses' => 'CarController@deleteRecord']);
        });
}
