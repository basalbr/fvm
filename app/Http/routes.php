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

Route::get('/admin', ['as' => 'admin', 'uses' => 'AdminController@index','middleware'=>'admin']);

Route::get('/admin/imposto/', ['as' => 'listar-imposto', 'uses' => 'ImpostoController@index','middleware'=>'admin']);
Route::get('/admin/imposto/cadastrar', ['as' => 'cadastrar-imposto', 'uses' => 'ImpostoController@create','middleware'=>'admin']);
Route::post('/admin/imposto/cadastrar', ['as' => 'cadastrar-imposto', 'uses' => 'ImpostoController@store','middleware'=>'admin']);
Route::get('/admin/imposto/editar/{id}', ['as' => 'editar-imposto', 'uses' => 'ImpostoController@edit','middleware'=>'admin']);
Route::post('/admin/imposto/editar/{id}', ['as' => 'editar-imposto', 'uses' => 'ImpostoController@update','middleware'=>'admin']);

Route::get('/admin/simples-nacional/', ['as' => 'listar-simples-nacional', 'uses' => 'SimplesNacionalController@index','middleware'=>'admin']);
Route::get('/admin/simples-nacional/cadastrar', ['as' => 'cadastrar-simples-nacional', 'uses' => 'SimplesNacionalController@create','middleware'=>'admin']);
Route::post('/admin/simples-nacional/cadastrar', ['as' => 'cadastrar-simples-nacional', 'uses' => 'SimplesNacionalController@store','middleware'=>'admin']);
Route::get('/admin/simples-nacional/editar/{id}', ['as' => 'editar-simples-nacional', 'uses' => 'SimplesNacionalController@edit','middleware'=>'admin']);
Route::post('/admin/simples-nacional/editar/{id}', ['as' => 'editar-simples-nacional', 'uses' => 'SimplesNacionalController@update','middleware'=>'admin']);

Route::get('/admin/tipo-tributacao/', ['as' => 'listar-tipo-tributacao', 'uses' => 'TipoTributacaoController@index','middleware'=>'admin']);
Route::get('/admin/tipo-tributacao/cadastrar', ['as' => 'cadastrar-tipo-tributacao', 'uses' => 'TipoTributacaoController@create','middleware'=>'admin']);
Route::post('/admin/tipo-tributacao/cadastrar', ['as' => 'cadastrar-tipo-tributacao', 'uses' => 'TipoTributacaoController@store','middleware'=>'admin']);
Route::get('/admin/tipo-tributacao/editar/{id}', ['as' => 'editar-tipo-tributacao', 'uses' => 'TipoTributacaoController@edit','middleware'=>'admin']);
Route::post('/admin/tipo-tributacao/editar/{id}', ['as' => 'editar-tipo-tributacao', 'uses' => 'TipoTributacaoController@update','middleware'=>'admin']);

Route::get('/admin/natureza-juridica/', ['as' => 'listar-natureza-juridica', 'uses' => 'NaturezaJuridicaController@index','middleware'=>'admin']);
Route::get('/admin/natureza-juridica/cadastrar', ['as' => 'cadastrar-natureza-juridica', 'uses' => 'NaturezaJuridicaController@create','middleware'=>'admin']);
Route::post('/admin/natureza-juridica/cadastrar', ['as' => 'cadastrar-natureza-juridica', 'uses' => 'NaturezaJuridicaController@store','middleware'=>'admin']);
Route::get('/admin/natureza-juridica/editar/{id}', ['as' => 'editar-natureza-juridica', 'uses' => 'NaturezaJuridicaController@edit','middleware'=>'admin']);
Route::post('/admin/natureza-juridica/editar/{id}', ['as' => 'editar-natureza-juridica', 'uses' => 'NaturezaJuridicaController@update','middleware'=>'admin']);

Route::get('/admin/cnae/', ['as' => 'listar-cnae', 'uses' => 'CnaeController@index','middleware'=>'admin']);
Route::get('/admin/cnae/cadastrar', ['as' => 'cadastrar-cnae', 'uses' => 'CnaeController@create','middleware'=>'admin']);
Route::post('/admin/cnae/cadastrar', ['as' => 'cadastrar-cnae', 'uses' => 'CnaeController@store','middleware'=>'admin']);
Route::get('/admin/cnae/editar/{id}', ['as' => 'editar-cnae', 'uses' => 'CnaeController@edit','middleware'=>'admin']);
Route::post('/admin/cnae/editar/{id}', ['as' => 'editar-cnae', 'uses' => 'CnaeController@update','middleware'=>'admin']);

Route::get('/admin/chamados/', ['as' => 'listar-chamados', 'uses' => 'ChamadosController@index','middleware'=>'admin']);
Route::get('/admin/chamados/visualizar/{id}', ['as' => 'visualizar-chamados', 'uses' => 'ChamadosController@edit','middleware'=>'admin']);
Route::post('/admin/chamados/visualizar/{id}', ['as' => 'visualizar-chamados', 'uses' => 'ChamadosController@update','middleware'=>'admin']);

Route::get('/dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index','middleware'=>'auth']);
Route::get('/chamados', ['as' => 'listar-chamados-usuario', 'uses' => 'ChamadosController@indexUsuario','middleware'=>'auth']);
Route::get('/chamados/cadastrar', ['as' => 'cadastrar-chamado', 'uses' => 'ChamadosController@create','middleware'=>'auth']);
Route::post('/chamados/cadastrar', ['uses' => 'ChamadosController@store','middleware'=>'auth']);
Route::get('/chamados/responder/{id}', ['as' => 'responder-chamado-usuario', 'uses' => 'ChamadosController@edit','middleware'=>'admin']);
Route::post('/chamados/responder/{id}', ['as' => 'responder-chamado-usuario', 'uses' => 'ChamadosController@update','middleware'=>'admin']);
Route::get('/acessar', ['as' => 'acessar', 'uses' => 'HomeController@acessar','middleware'=>'guest']);
Route::post('/acessar', ['as' => 'acessar', 'uses' => 'HomeController@checkEmail']);
Route::get('/register', ['as' => 'register', 'uses' => 'HomeController@register']);

// Empresa routes...
Route::get('/empresas', ['as' => 'empresas', 'uses' => 'EmpresaController@index','middleware'=>'auth']);
Route::get('/empresas/cadastrar', ['as' => 'cadastrar-empresa', 'uses' => 'EmpresaController@create','middleware'=>'auth']);
Route::post('/empresas/cadastrar', ['uses' => 'EmpresaController@store','middleware'=>'auth']);

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

Route::post('/ajax/cnae/', ['as' => 'ajax-cnae', 'uses' => 'CnaeController@ajax','middleware'=>'auth']);
