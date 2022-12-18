<?php

/**
 * @file
 * Маршруты бд модулей предметов
 */

use App\Components\Instructors\Controllers\InstructorController;

if (isset($router)) {
    $router->group(
        [
            'prefix' => '/api/instructors',
            'namespace' => 'App\Components\Instructors\Controllers'
        ],
        function () use ($router) {
            $router->get('/',           ['uses' => 'InstructorController@baseGet']);
            $router->get('/one',        ['uses' => 'InstructorController@getRecord']);
            $router->get('/create',    ['uses' => 'InstructorController@createRecord']);
            $router->get('/update',    ['uses' => 'InstructorController@updateRecord']);
            $router->get('/delete',    ['uses' => 'InstructorController@deleteRecord']);
        });
}
