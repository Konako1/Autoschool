<?php

/**
 * @file
 * Маршруты бд групп
 */

use App\Http\Controllers\GroupController;

if (isset($router)) {
    $router->group(
        [
            'prefix' => '/api/groups',
        ],
        function () use ($router) {
            $router->get('/',                   [GroupController::class, 'getAllRecords']);
            $router->get('/{id:[0-9]+}',        [GroupController::class, 'getRecord']);
            $router->post('/',                  [GroupController::class, 'createRecord']);
            $router->put('/{id:[0-9]+}',        [GroupController::class, 'updateRecord']);
            $router->delete('/{id:[0-9]+}',     [GroupController::class, 'deleteRecord']);
        });
}
