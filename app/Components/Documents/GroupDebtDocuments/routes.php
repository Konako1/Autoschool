<?php

/**
 * @file
 * Маршруты заявления в ГИБДД на получение прав (документ)
 */

use App\Components\Documents\GroupDebtDocuments\Controllers\GroupDebtDocumentController;

if (isset($router)) {
    $router->group(
        [
            'prefix' => '/api/documents/group-debt',
            'namespace' => 'App\Components\Documents\GroupDebtDocuments\Controllers'
        ],
        function () use ($router) {
            $router->get('/',           ['uses' => 'GroupDebtDocumentController@baseGet']);
            $router->get('/one',        ['uses' => 'GroupDebtDocumentController@getRecord']);
            $router->get('/create',    ['uses' => 'GroupDebtDocumentController@createRecord']);
            $router->get('/delete',    ['uses' => 'GroupDebtDocumentController@deleteRecord']);
        });
}
