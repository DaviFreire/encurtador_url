<?php

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->group(['prefix' => 'api', ], function () use ($router) {
    $router->post('registrar',  ['uses' => 'UserController@store']);
    $router->post('login',  ['uses' => 'AuthController@postLogin']);
    
    $router->group(["middleware" => "auth"], function () use ($router) {
        $router->put('user/{id}',  ['uses' => 'UserController@update']);
        $router->delete('user/{id}',  ['uses' => 'UserController@destroy']);

        $router->post('url/encurtar',  ['uses' => 'UrlController@store']);
        $router->get('url/info',  ['uses' => 'UrlController@show']);
        $router->get('url/user/{id}',  ['uses' => 'UrlController@showUser']);
    });
});