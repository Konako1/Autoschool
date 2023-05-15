<?php

/**
 * @file
 * Маршруты карточки учета вождения автомобиля (документ)
 */

use App\Components\Documents\CarDrivingRegistrationCardDocuments\Controllers\CarDrivingRegistrationCardDocumentController;

if (isset($router)) {
    $router->group(
        [
            'prefix' => '/api/documents/car-driving-registration-card',
            'namespace' => 'App\Components\Documents\CarDrivingRegistrationCardDocuments\Controllers'
        ],
        function () use ($router) {
            $router->get('/',           ['uses' => 'CarDrivingRegistrationCardDocumentController@baseGet']);
            $router->get('/one',        ['uses' => 'CarDrivingRegistrationCardDocumentController@getRecord']);
            $router->get('/create',    ['uses' => 'CarDrivingRegistrationCardDocumentController@createRecord']);
            $router->get('/delete',    ['uses' => 'CarDrivingRegistrationCardDocumentController@deleteRecord']);
        });
}
