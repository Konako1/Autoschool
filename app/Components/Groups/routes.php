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
            $router->get('/', ['uses' => 'GroupController@getAllRecords']);
            $router->post('/', ['uses' => 'GroupController@createRecord']);
        });
}
