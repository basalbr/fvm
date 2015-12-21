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
Route::get('/dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index','middleware'=>'auth']);
Route::get('/acessar', ['as' => 'acessar', 'uses' => 'HomeController@acessar','middleware'=>'guest']);
Route::post('/acessar', ['as' => 'acessar', 'uses' => 'HomeController@checkEmail']);
Route::get('/register', ['as' => 'register', 'uses' => 'HomeController@register']);

// Empresa routes...
Route::get('/empresas', ['as' => 'empresas', 'uses' => 'EmpresaController@index','middleware'=>'auth']);
Route::get('/empresas/cadastrar', ['as' => 'cadastrar-empresa', 'uses' => 'EmpresaController@create','middleware'=>'auth']);

// Registration routes...
Route::get('/registrar', ['uses' => 'Auth\AuthController@getRegister', 'as' => 'registrar']);
Route::post('/registrar', ['uses' => 'Auth\AuthController@postRegister', 'as' => 'registrar']);

//Login routes...
Route::get('/login', ['uses' => 'Auth\AuthController@getLogin', 'as' => 'login']);
Route::post('/login', ['uses' => 'Auth\AuthController@postLogin', 'as' => 'login']);



Route::get('/sair', ['uses' => 'Auth\AuthController@getLogout', 'as' => 'sair']);

Route::controllers([
   'password' => 'Auth\PasswordController',
]);
