<?php

/**
 * @file
 * Маршруты бд групп
 */

use App\Components\Groups\Controllers\GroupController;

if (isset($router)) {
    $router->group(
        [
            'prefix' => '/api/groups',
            'namespace' => 'App\Components\Groups\Controllers'
        ],
        function () use ($router) {
            $router->get('/',           ['uses' => 'GroupController@baseGet']);
            $router->get('/one',        ['uses' => 'GroupController@getRecord']);
            $router->get('/create',    ['uses' => 'GroupController@createRecord']);
            $router->get('/update',    ['uses' => 'GroupController@updateRecord']);
            $router->get('/delete',    ['uses' => 'GroupController@deleteRecord']);
            $router->get('/availableTimings',     ['uses' => 'GroupController@getAvailableTimings']);
            $router->get('/availableWeekdays',    ['uses' => 'GroupController@getAvailableWeekdays']);
        });
}
