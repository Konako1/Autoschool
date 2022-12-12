<?php

/**
 * @file
 * Маршруты бд групп
 */

if (isset($router)) {
    $router->group(
        [
            'prefix' => '/api/groups',
            'namespace' => 'App\Components\Groups\Controllers',
        ],
        function () use ($router) {
            $router->get('/',                   ['uses' => 'GroupController@getAllRecords']);
            $router->get('/{id:[0-9]+}',        ['uses' => 'GroupController@getRecord']);
            $router->post('/',                  ['uses' => 'GroupController@createRecord']);
            $router->post('/{id:[0-9]+}',       ['uses' => 'GroupController@updateRecord']);
            $router->delete('/{id:[0-9]+}',     ['uses' => 'GroupController@deleteRecord']);
        });
}
