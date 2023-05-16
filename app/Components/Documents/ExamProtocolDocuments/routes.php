<?php

/**
 * @file
 * Маршруты экзаменационный протокол (документ)
 */

use App\Components\Documents\ExamProtocolDocuments\Controllers\ExamProtocolDocumentController;

if (isset($router)) {
    $router->group(
        [
            'prefix' => '/api/documents/exam-protocol',
            'namespace' => 'App\Components\Documents\ExamProtocolDocuments\Controllers'
        ],
        function () use ($router) {
            $router->get('/',           ['uses' => 'ExamProtocolDocumentController@baseGet']);
            $router->get('/one',        ['uses' => 'ExamProtocolDocumentController@getRecord']);
            $router->get('/create',    ['uses' => 'ExamProtocolDocumentController@createRecord']);
            $router->get('/delete',    ['uses' => 'ExamProtocolDocumentController@deleteRecord']);
        });
}
