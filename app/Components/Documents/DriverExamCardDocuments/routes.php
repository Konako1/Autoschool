<?php

/**
 * @file
 * Маршруты экзаменационной карточки водителя (документ)
 */

use App\Components\Documents\DriverExamCardDocuments\Controllers\DriverExamCardDocumentController;

if (isset($router)) {
    $router->group(
        [
            'prefix' => '/api/documents/driver-exam-card',
            'namespace' => 'App\Components\Documents\DriverExamCardDocuments\Controllers'
        ],
        function () use ($router) {
            $router->get('/',           ['uses' => 'DriverExamCardDocumentController@baseGet']);
            $router->get('/one',        ['uses' => 'DriverExamCardDocumentController@getRecord']);
            $router->get('/create',    ['uses' => 'DriverExamCardDocumentController@createRecord']);
            $router->get('/delete',    ['uses' => 'DriverExamCardDocumentController@deleteRecord']);
        });
}
