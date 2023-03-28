<?php

/**
 * @file
 * Маршруты бд курсов
 */

use App\Components\Courses\Controllers\CourseController;

if (isset($router)) {
    $router->group(
        [
            'prefix' => '/api/courses',
            'namespace' => 'App\Components\Courses\Controllers'
        ],
        function () use ($router) {
            $router->get('/',           ['uses' => 'CourseController@baseGet']);
            $router->get('/one',        ['uses' => 'CourseController@getRecord']);
            $router->get('/create',    ['uses' => 'CourseController@createRecord']);
            $router->get('/update',    ['uses' => 'CourseController@updateRecord']);
            $router->get('/delete',    ['uses' => 'CourseController@deleteRecord']);
        });
}
