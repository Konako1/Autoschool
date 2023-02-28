<?php

/**
 * @file
 * Маршруты бд занятий
 */

use App\Components\Lessons\Controllers\LessonController;

if (isset($router)) {
    $router->group(
        [
            'prefix' => '/api/lessons',
            'namespace' => 'App\Components\Lessons\Controllers'
        ],
        function () use ($router) {
            $router->get('/',           ['uses' => 'LessonController@baseGet']);
            $router->get('/one',        ['uses' => 'LessonController@getRecord']);
            $router->get('/create',    ['uses' => 'LessonController@createRecord']);
            $router->get('/update',    ['uses' => 'LessonController@updateRecord']);
            $router->get('/delete',    ['uses' => 'LessonController@deleteRecord']);
        });
}
