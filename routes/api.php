<?php

/** @var Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use App\Http\Controllers\GroupController;
use Laravel\Lumen\Routing\Router;

$router->get('/', function () use ($router) {
    phpinfo();
});

$router->group(
    [
        'prefix' => '/api/groups',
    ],
    function () use ($router) {
        $router->get('/',                   [GroupController::class, 'getAllRecords']);
        $router->get('/{id:[0-9]+}',        [GroupController::class, 'getRecord']);
        $router->post('/',                  [GroupController::class, 'createRecord']);
        $router->put('/{id:[0-9]+}',        [GroupController::class, 'updateRecord']);
        $router->delete('/{id:[0-9]+}',     [GroupController::class, 'deleteRecord']);
    });
