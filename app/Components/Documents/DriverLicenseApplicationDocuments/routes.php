<?php

/**
 * @file
 * Маршруты заявления в ГИБДД на получение прав (документ)
 */

use App\Components\Documents\DriverLicenseApplicationDocuments\Controllers\DriverLicenseApplicationDocumentController;

if (isset($router)) {
    $router->group(
        [
            'prefix' => '/api/documents/driver-license-application',
            'namespace' => 'App\Components\Documents\DriverLicenseApplicationDocuments\Controllers'
        ],
        function () use ($router) {
            $router->get('/',           ['uses' => 'DriverLicenseApplicationDocumentController@baseGet']);
            $router->get('/one',        ['uses' => 'DriverLicenseApplicationDocumentController@getRecord']);
            $router->get('/create',    ['uses' => 'DriverLicenseApplicationDocumentController@createRecord']);
            $router->get('/delete',    ['uses' => 'DriverLicenseApplicationDocumentController@deleteRecord']);
        });
}
