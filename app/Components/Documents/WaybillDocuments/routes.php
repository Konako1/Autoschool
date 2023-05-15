<?php

/**
 * @file
 * Маршруты путевого листа (документ)
 */

use App\Components\Documents\WaybillDocuments\Controllers\WaybillDocumentController;

if (isset($router)) {
    $router->group(
        [
            'prefix' => '/api/documents/waybill',
            'namespace' => 'App\Components\Documents\WaybillDocuments\Controllers'
        ],
        function () use ($router) {
            $router->get('/',           ['uses' => 'WaybillDocumentController@baseGet']);
            $router->get('/one',        ['uses' => 'WaybillDocumentController@getRecord']);
            $router->get('/create',    ['uses' => 'WaybillDocumentController@createRecord']);
            $router->get('/delete',    ['uses' => 'WaybillDocumentController@deleteRecord']);
        });
}
