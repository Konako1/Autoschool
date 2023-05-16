<?php

/**
 * @file
 * Маршруты приказа на регистрацию (документ)
 */

use App\Components\Documents\RegistrationOrderDocuments\Controllers\RegistrationOrderDocumentController;

if (isset($router)) {
    $router->group(
        [
            'prefix' => '/api/documents/registration-order',
            'namespace' => 'App\Components\Documents\RegistrationOrderDocuments\Controllers'
        ],
        function () use ($router) {
            $router->get('/',           ['uses' => 'RegistrationOrderDocumentController@baseGet']);
            $router->get('/one',        ['uses' => 'RegistrationOrderDocumentController@getRecord']);
            $router->get('/create',    ['uses' => 'RegistrationOrderDocumentController@createRecord']);
            $router->get('/delete',    ['uses' => 'RegistrationOrderDocumentController@deleteRecord']);
        });
}
