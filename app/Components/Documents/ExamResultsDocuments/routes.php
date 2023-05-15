<?php

/**
 * @file
 * Маршруты результатов экзамена ГИБДД (документ)
 */

use App\Components\Documents\ExamResultsDocuments\Controllers\ExamResultsDocumentController;

if (isset($router)) {
    $router->group(
        [
            'prefix' => '/api/documents/exam-results',
            'namespace' => 'App\Components\Documents\ExamResultsDocuments\Controllers'
        ],
        function () use ($router) {
            $router->get('/',           ['uses' => 'ExamResultsDocumentController@baseGet']);
            $router->get('/one',        ['uses' => 'ExamResultsDocumentController@getRecord']);
            $router->get('/create',    ['uses' => 'ExamResultsDocumentController@createRecord']);
            $router->get('/delete',    ['uses' => 'ExamResultsDocumentController@deleteRecord']);
        });
}
