<?php

/**
 * @file
 * Маршруты бд категорий транспорта
 */

use App\Components\Categories\Controllers\CategoryController;

if (isset($router)) {
    $router->group(
        [
            'prefix' => '/api/categories',
            'namespace' => 'App\Components\Categories\Controllers'
        ],
        function () use ($router) {
            $router->get('/',           ['uses' => 'CategoryController@baseGet']);
            $router->get('/one',        ['uses' => 'CategoryController@getRecord']);
        });
}
