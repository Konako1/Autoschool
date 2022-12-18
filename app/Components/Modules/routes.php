<?php

/**
 * @file
 * Маршруты бд модулей предметов
 */

use App\Components\Modules\Controllers\ModuleController;

if (isset($router)) {
    $router->group(
        [
            'prefix' => '/api/modules',
            'namespace' => 'App\Components\Modules\Controllers'
        ],
        function () use ($router) {
            $router->get('/',           ['uses' => 'ModuleController@baseGet']);
            $router->get('/one',        ['uses' => 'ModuleController@getRecord']);
            $router->get('/create',    ['uses' => 'ModuleController@createRecord']);
            $router->get('/update',    ['uses' => 'ModuleController@updateRecord']);
            $router->get('/delete',    ['uses' => 'ModuleController@deleteRecord']);
        });
}
