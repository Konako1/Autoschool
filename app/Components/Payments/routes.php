<?php

/**
 * @file
 * Маршруты бд платежей
 */

use App\Components\Payments\Controllers\PaymentController;

if (isset($router)) {
    $router->group(
        [
            'prefix' => '/api/payments',
            'namespace' => 'App\Components\Payments\Controllers'
        ],
        function () use ($router) {
            $router->get('/',           ['uses' => 'PaymentController@baseGet']);
            $router->get('/one',        ['uses' => 'PaymentController@getRecord']);
            $router->get('/debt',       ['uses' => 'PaymentController@getDebtByGroup']);
            $router->get('/create',    ['uses' => 'PaymentController@createRecord']);
            $router->get('/update',    ['uses' => 'PaymentController@updateRecord']);
            $router->get('/delete',    ['uses' => 'PaymentController@deleteRecord']);
        });
}
