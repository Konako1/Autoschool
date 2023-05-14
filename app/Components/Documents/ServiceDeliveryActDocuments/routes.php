<?php

/**
 * @file
 * Маршруты акта на оказание услуг (документ)
 */

use App\Components\Documents\ServiceDeliveryActDocuments\Controllers\ServiceDeliveryActDocumentController;

if (isset($router)) {
    $router->group(
        [
            'prefix' => '/api/documents/service-delivery-act',
            'namespace' => 'App\Components\Documents\ServiceDeliveryActDocuments\Controllers'
        ],
        function () use ($router) {
            $router->get('/',           ['uses' => 'ServiceDeliveryActDocumentController@baseGet']);
            $router->get('/one',        ['uses' => 'ServiceDeliveryActDocumentController@getRecord']);
            $router->get('/create',    ['uses' => 'ServiceDeliveryActDocumentController@createRecord']);
            $router->get('/delete',    ['uses' => 'ServiceDeliveryActDocumentController@deleteRecord']);
        });
}
