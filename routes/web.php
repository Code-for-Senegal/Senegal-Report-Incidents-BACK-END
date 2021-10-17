<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Models\TypeIncident;

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

header('Access-Control-Allow-Origin', '*');
header('Access-Control-Allow-Methods', 'GET,HEAD,PUT,POST,DELETE,PATCH,OPTIONS');
header('Access-Control-Allow-Headers', 'Content-Type, X-Auth-Token, Origin, Authorization');

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/', 'UserController@index');

$router->post('/users', 'UserController@create');
$router->post('/login', 'UserController@login');

$router->get('/type-incidents', function () {
    return response()->json(TypeIncident::all());
});

$router->post('/evenements', 'EvenementController@create');
$router->get('evenements/{email}', 'EvenementController@myEvenements');
