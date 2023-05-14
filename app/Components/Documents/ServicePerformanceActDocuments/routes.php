<?php

/**
 * @file
 * Маршруты акта о выполнении услуги (документ)
 */

use App\Components\Documents\ServicePerformanceActDocuments\Controllers\ServicePerformanceActDocumentController;

if (isset($router)) {
    $router->group(
        [
            'prefix' => '/api/documents/service-performance-act',
            'namespace' => 'App\Components\Documents\ServicePerformanceActDocuments\Controllers'
        ],
        function () use ($router) {
            $router->get('/',           ['uses' => 'ServicePerformanceActDocumentController@baseGet']);
            $router->get('/one',        ['uses' => 'ServicePerformanceActDocumentController@getRecord']);
            $router->get('/create',    ['uses' => 'ServicePerformanceActDocumentController@createRecord']);
            $router->get('/delete',    ['uses' => 'ServicePerformanceActDocumentController@deleteRecord']);
        });
}
