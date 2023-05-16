<?php

/**
 * @file
 * Маршруты расписания (документ)
 */

use App\Components\Documents\ScheduleDocuments\Controllers\ScheduleDocumentController;

if (isset($router)) {
    $router->group(
        [
            'prefix' => '/api/documents/schedule',
            'namespace' => 'App\Components\Documents\ScheduleDocuments\Controllers'
        ],
        function () use ($router) {
            $router->get('/',           ['uses' => 'ScheduleDocumentController@baseGet']);
            $router->get('/one',        ['uses' => 'ScheduleDocumentController@getRecord']);
            $router->get('/create',    ['uses' => 'ScheduleDocumentController@createRecord']);
            $router->get('/delete',    ['uses' => 'ScheduleDocumentController@deleteRecord']);
        });
}
