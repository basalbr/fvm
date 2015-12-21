<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

Route::get('/', function () {
    return view('index');
});
Route::get('/acessar', ['as' => 'acessar', 'uses' => 'HomeController@acessar']);
Route::post('/acessar', ['as' => 'acessar', 'uses' => 'HomeController@checkEmail']);
Route::get('/register', ['as' => 'register', 'uses' => 'HomeController@register']);

// Registration routes...
Route::get('/registrar', ['uses' => 'Auth\AuthController@getRegister', 'as' => 'registrar']);
Route::post('/registrar', ['uses' => 'Auth\AuthController@postRegister', 'as' => 'registrar']);

Route::controllers([
   'password' => 'Auth\PasswordController',
]);
