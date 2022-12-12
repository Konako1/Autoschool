<?php

/**
 * @file
 * Маршруты бд студентов
 */

if (isset($router)) {
    $router->group(
        [
            'prefix' => '/api',
            'namespace' => '\App\Components\Students\Controllers'
        ],
        function () use ($router) {
            $router->get('/students', ['uses' => 'StudentController@getAllRecords']);
        });

    $router->group(
        [
            'prefix' => '/api/groups/{groupId:[0-9]+}/students',
            'namespace' => '\App\Components\Students\Controllers'
        ],
        function () use ($router) {
            $router->get('/',                   ['uses' => 'StudentController@getAllRecordsByGroup']);
            $router->get('/{id:[0-9]+}',        ['uses' => 'StudentController@getRecord']);
            $router->post('',                   ['uses' => 'StudentController@createRecord']);
            $router->put('/{id:[0-9]+}',        ['uses' => 'StudentController@updateRecord']);
            $router->delete('/{id:[0-9]+}',     ['uses' => 'StudentController@deleteRecord']);
        });
}
