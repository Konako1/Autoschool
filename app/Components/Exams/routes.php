<?php

/**
 * @file
 * Маршруты бд экзаменов
 */

use App\Components\Exams\Controllers\ExamController;

if (isset($router)) {
    $router->group(
        [
            'prefix' => '/api/exams',
            'namespace' => 'App\Components\Exams\Controllers'
        ],
        function () use ($router) {
            $router->get('/',           ['uses' => 'ExamController@baseGet']);
            $router->get('/one',        ['uses' => 'ExamController@getRecord']);
            $router->get('/create',    ['uses' => 'ExamController@createRecord']);
            $router->get('/update',    ['uses' => 'ExamController@updateRecord']);
            $router->get('/delete',    ['uses' => 'ExamController@deleteRecord']);
        });
}
