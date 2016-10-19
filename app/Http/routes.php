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

Route::get('/', ['as' => 'home', 'uses' => function () {
        return view('index');
    }]);

Route::get('/admin', ['as' => 'admin', 'uses' => 'AdminController@index', 'middleware' => 'admin']);

Route::get('/pagseguro/teste', ['as' => 'pagseguro.teste', 'uses' => 'PagseguroController@teste']);
Route::get('/pagseguro/redirect', ['as' => 'pagseguro.redirect', 'uses' => 'PagseguroController@redirect']);
Route::post('/pagseguro/notification', [
    'uses' => '\laravel\pagseguro\Platform\Laravel5\NotificationController@notification',
    'as' => 'pagseguro.notification',
]);

Route::get('/testeimpostos', ['as' => 'testeimposto', 'uses' => 'ProcessoController@abreProcessos', 'middleware' => 'admin']);
Route::get('/admin/chat/', ['as' => 'listar-chat', 'uses' => 'ChatController@index', 'middleware' => 'admin']);
Route::get('/admin/chat/visualizar/{id}', ['as' => 'visualizar-chat', 'uses' => 'ChatController@edit', 'middleware' => 'admin']);

Route::get('/admin/pro-labore/', ['as' => 'listar-pro-labore', 'uses' => 'ProlaboreController@index', 'middleware' => 'admin']);
Route::get('/admin/pro-labore/historico', ['as' => 'listar-pro-labore-historico', 'uses' => 'ProlaboreController@historico', 'middleware' => 'admin']);
Route::get('/admin/socio/{id}/pro-labore/cadastrar/', ['as' => 'cadastrar-pro-labore', 'uses' => 'ProlaboreController@create', 'middleware' => 'admin']);
Route::post('/admin/socio/{id}/pro-labore/cadastrar/', ['as' => 'cadastrar-pro-labore', 'uses' => 'ProlaboreController@store', 'middleware' => 'admin']);
Route::get('/admin/socio/{id}/pro-labore/editar/{pro_labore}', ['as' => 'editar-pro-labore', 'uses' => 'ProlaboreController@edit', 'middleware' => 'admin']);
Route::post('/admin/socio/{id}/pro-labore/editar/{pro_labore}', ['as' => 'editar-pro-labore', 'uses' => 'ProlaboreController@update', 'middleware' => 'admin']);

Route::get('/pro-labore/', ['as' => 'listar-pro-labore-cliente', 'uses' => 'ProlaboreController@indexCliente', 'middleware' => 'auth']);
Route::get('/socios/', ['as' => 'listar-socios-apenas', 'uses' => 'SocioController@indexSocios', 'middleware' => 'auth']);
Route::get('/socio/{id}/pro-labore', ['as' => 'listar-pro-labore-socio', 'uses' => 'ProlaboreController@socio', 'middleware' => 'auth']);
Route::get('/socio/{id}/pro-labore/{id_pro_labore}', ['as' => 'visualizar-pro-labore-socio', 'uses' => 'ProlaboreController@socioEdit', 'middleware' => 'auth']);

Route::get('/admin/imposto/', ['as' => 'listar-imposto', 'uses' => 'ImpostoController@index', 'middleware' => 'admin']);
Route::get('/admin/imposto/cadastrar', ['as' => 'cadastrar-imposto', 'uses' => 'ImpostoController@create', 'middleware' => 'admin']);
Route::post('/admin/imposto/cadastrar', ['as' => 'cadastrar-imposto', 'uses' => 'ImpostoController@store', 'middleware' => 'admin']);
Route::get('/admin/imposto/editar/{id}', ['as' => 'editar-imposto', 'uses' => 'ImpostoController@edit', 'middleware' => 'admin']);
Route::post('/admin/imposto/editar/{id}', ['as' => 'editar-imposto', 'uses' => 'ImpostoController@update', 'middleware' => 'admin']);

Route::get('/admin/imposto/{id_imposto}/instrucoes', ['as' => 'listar-instrucao', 'uses' => 'InstrucaoController@index', 'middleware' => 'admin']);
Route::get('/admin/imposto/{id_imposto}/instrucoes/cadastrar', ['as' => 'cadastrar-instrucao', 'uses' => 'InstrucaoController@create', 'middleware' => 'admin']);
Route::post('/admin/imposto/{id_imposto}/instrucoes/cadastrar', ['as' => 'cadastrar-instrucao', 'uses' => 'InstrucaoController@store', 'middleware' => 'admin']);
Route::get('/admin/imposto/{id_imposto}/instrucoes/editar/{id_instrucao}', ['as' => 'editar-instrucao', 'uses' => 'InstrucaoController@edit', 'middleware' => 'admin']);
Route::post('/admin/imposto/{id_imposto}/instrucoes/editar/{id_instrucao}', ['as' => 'editar-instrucao', 'uses' => 'InstrucaoController@update', 'middleware' => 'admin']);

Route::get('/empresa/{id_empresa}/socios', ['as' => 'listar-socios', 'uses' => 'SocioController@index', 'middleware' => 'auth']);
Route::get('/empresa/{id_empresa}/socios/cadastrar', ['as' => 'cadastrar-socio', 'uses' => 'SocioController@create', 'middleware' => 'auth']);
Route::post('/empresa/{id_empresa}/socios/cadastrar', ['as' => 'cadastrar-socio', 'uses' => 'SocioController@store', 'middleware' => 'auth']);
Route::get('/empresa/{id_empresa}/socios/editar/{id_socio}', ['as' => 'editar-socio', 'uses' => 'SocioController@edit', 'middleware' => 'auth']);
Route::post('/empresa/{id_empresa}/socios/editar/{id_socio}', ['uses' => 'SocioController@update', 'middleware' => 'auth']);

Route::get('/admin/imposto/{id_imposto}/informacoes-extras', ['as' => 'listar-informacao-extra', 'uses' => 'InformacaoExtraController@index', 'middleware' => 'admin']);
Route::get('/admin/imposto/{id_imposto}/informacoes-extras/cadastrar', ['as' => 'cadastrar-informacao-extra', 'uses' => 'InformacaoExtraController@create', 'middleware' => 'admin']);
Route::post('/admin/imposto/{id_imposto}/informacoes-extras/cadastrar', ['as' => 'cadastrar-informacao-extra', 'uses' => 'InformacaoExtraController@store', 'middleware' => 'admin']);
Route::get('/admin/imposto/{id_imposto}/informacoes-extras/editar/{id_informacao_extra}', ['as' => 'editar-informacao-extra', 'uses' => 'InformacaoExtraController@edit', 'middleware' => 'admin']);
Route::post('/admin/imposto/{id_imposto}/informacoes-extras/editar/{id_informacao_extra}', ['as' => 'editar-informacao-extra', 'uses' => 'InformacaoExtraController@update', 'middleware' => 'admin']);

Route::get('/admin/simples-nacional/', ['as' => 'listar-simples-nacional', 'uses' => 'SimplesNacionalController@index', 'middleware' => 'admin']);
Route::get('/admin/simples-nacional/cadastrar', ['as' => 'cadastrar-simples-nacional', 'uses' => 'SimplesNacionalController@create', 'middleware' => 'admin']);
Route::post('/admin/simples-nacional/cadastrar', ['as' => 'cadastrar-simples-nacional', 'uses' => 'SimplesNacionalController@store', 'middleware' => 'admin']);
Route::get('/admin/simples-nacional/editar/{id}', ['as' => 'editar-simples-nacional', 'uses' => 'SimplesNacionalController@edit', 'middleware' => 'admin']);
Route::post('/admin/simples-nacional/editar/{id}', ['as' => 'editar-simples-nacional', 'uses' => 'SimplesNacionalController@update', 'middleware' => 'admin']);

Route::get('/admin/plano/', ['as' => 'listar-plano', 'uses' => 'PlanoController@index', 'middleware' => 'admin']);
Route::get('/admin/plano/cadastrar', ['as' => 'cadastrar-plano', 'uses' => 'PlanoController@create', 'middleware' => 'admin']);
Route::post('/admin/plano/cadastrar', ['as' => 'cadastrar-plano', 'uses' => 'PlanoController@store', 'middleware' => 'admin']);
Route::get('/admin/plano/editar/{id}', ['as' => 'editar-plano', 'uses' => 'PlanoController@edit', 'middleware' => 'admin']);
Route::post('/admin/plano/editar/{id}', ['as' => 'editar-plano', 'uses' => 'PlanoController@update', 'middleware' => 'admin']);

Route::get('/admin/faq/', ['as' => 'listar-faq', 'uses' => 'FaqController@index', 'middleware' => 'admin']);
Route::get('/admin/faq/cadastrar', ['as' => 'cadastrar-faq', 'uses' => 'FaqController@create', 'middleware' => 'admin']);
Route::post('/admin/faq/cadastrar', ['as' => 'cadastrar-faq', 'uses' => 'FaqController@store', 'middleware' => 'admin']);
Route::get('/admin/faq/editar/{id}', ['as' => 'editar-faq', 'uses' => 'FaqController@edit', 'middleware' => 'admin']);
Route::post('/admin/faq/editar/{id}', ['as' => 'editar-faq', 'uses' => 'FaqController@update', 'middleware' => 'admin']);

Route::get('/admin/tipo-tributacao/', ['as' => 'listar-tipo-tributacao', 'uses' => 'TipoTributacaoController@index', 'middleware' => 'admin']);
Route::get('/admin/tipo-tributacao/cadastrar', ['as' => 'cadastrar-tipo-tributacao', 'uses' => 'TipoTributacaoController@create', 'middleware' => 'admin']);
Route::post('/admin/tipo-tributacao/cadastrar', ['as' => 'cadastrar-tipo-tributacao', 'uses' => 'TipoTributacaoController@store', 'middleware' => 'admin']);
Route::get('/admin/tipo-tributacao/editar/{id}', ['as' => 'editar-tipo-tributacao', 'uses' => 'TipoTributacaoController@edit', 'middleware' => 'admin']);
Route::post('/admin/tipo-tributacao/editar/{id}', ['as' => 'editar-tipo-tributacao', 'uses' => 'TipoTributacaoController@update', 'middleware' => 'admin']);

Route::get('/admin/natureza-juridica/', ['as' => 'listar-natureza-juridica', 'uses' => 'NaturezaJuridicaController@index', 'middleware' => 'admin']);
Route::get('/admin/natureza-juridica/cadastrar', ['as' => 'cadastrar-natureza-juridica', 'uses' => 'NaturezaJuridicaController@create', 'middleware' => 'admin']);
Route::post('/admin/natureza-juridica/cadastrar', ['as' => 'cadastrar-natureza-juridica', 'uses' => 'NaturezaJuridicaController@store', 'middleware' => 'admin']);
Route::get('/admin/natureza-juridica/editar/{id}', ['as' => 'editar-natureza-juridica', 'uses' => 'NaturezaJuridicaController@edit', 'middleware' => 'admin']);
Route::post('/admin/natureza-juridica/editar/{id}', ['as' => 'editar-natureza-juridica', 'uses' => 'NaturezaJuridicaController@update', 'middleware' => 'admin']);

Route::get('/noticias/', ['as' => 'listar-noticias-site', 'uses' => 'NoticiaController@indexSite']);
Route::get('/noticias/{id}/{slug}', ['as' => 'ler-noticia', 'uses' => 'NoticiaController@ler']);

Route::get('/admin/noticias/', ['as' => 'listar-noticias', 'uses' => 'NoticiaController@index', 'middleware' => 'admin']);
Route::get('/admin/noticias/cadastrar', ['as' => 'cadastrar-noticia', 'uses' => 'NoticiaController@create', 'middleware' => 'admin']);
Route::post('/admin/noticias/cadastrar', ['as' => 'cadastrar-noticia', 'uses' => 'NoticiaController@store', 'middleware' => 'admin']);
Route::get('/admin/noticias/editar/{id}', ['as' => 'editar-noticia', 'uses' => 'NoticiaController@edit', 'middleware' => 'admin']);
Route::post('/admin/noticias/editar/{id}', ['as' => 'editar-noticia', 'uses' => 'NoticiaController@update', 'middleware' => 'admin']);

Route::get('/admin/cnae/', ['as' => 'listar-cnae', 'uses' => 'CnaeController@index', 'middleware' => 'admin']);
Route::get('/admin/cnae/cadastrar', ['as' => 'cadastrar-cnae', 'uses' => 'CnaeController@create', 'middleware' => 'admin']);
Route::post('/admin/cnae/cadastrar', ['as' => 'cadastrar-cnae', 'uses' => 'CnaeController@store', 'middleware' => 'admin']);
Route::get('/admin/cnae/editar/{id}', ['as' => 'editar-cnae', 'uses' => 'CnaeController@edit', 'middleware' => 'admin']);
Route::post('/admin/cnae/editar/{id}', ['as' => 'editar-cnae', 'uses' => 'CnaeController@update', 'middleware' => 'admin']);

Route::get('/admin/chamados/', ['as' => 'listar-chamados', 'uses' => 'ChamadosController@index', 'middleware' => 'admin']);
Route::get('/admin/chamados/visualizar/{id}', ['as' => 'visualizar-chamados', 'uses' => 'ChamadosController@edit', 'middleware' => 'admin']);
Route::post('/admin/chamados/visualizar/{id}', ['as' => 'visualizar-chamados', 'uses' => 'ChamadosController@update', 'middleware' => 'admin']);


Route::get('/mensalidades/', ['as' => 'listar-mensalidades', 'uses' => 'MensalidadeController@index', 'middleware' => 'auth']);
Route::get('/admin/mensalidades/', ['as' => 'listar-mensalidades-admin', 'uses' => 'MensalidadeController@indexAdmin', 'middleware' => 'admin']);
Route::get('/pagamentos-pendentes/', ['as' => 'listar-pagamentos-pendentes', 'uses' => 'PagamentoController@index', 'middleware' => 'auth']);
Route::get('/historico-pagamentos/', ['as' => 'listar-historico-pagamentos', 'uses' => 'PagamentoController@historico', 'middleware' => 'auth']);

Route::get('/admin/apuracoes/', ['as' => 'listar-processos-admin', 'uses' => 'ProcessoController@index', 'middleware' => 'admin']);
Route::get('/admin/apuracoes/visualizar/{id}', ['as' => 'visualizar-processo-admin', 'uses' => 'ProcessoController@edit', 'middleware' => 'admin']);
Route::post('/admin/apuracoes/visualizar/{id}', ['as' => 'visualizar-processo-admin', 'uses' => 'ProcessoController@update', 'middleware' => 'admin']);

Route::get('/dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index', 'middleware' => 'auth']);
Route::get('/calendario', ['as' => 'calendario', 'uses' => 'CalendarioController@index', 'middleware' => 'auth']);
Route::get('/chamados', ['as' => 'listar-chamados-usuario', 'uses' => 'ChamadosController@indexUsuario', 'middleware' => 'auth']);
Route::get('/chamados/cadastrar', ['as' => 'cadastrar-chamado', 'uses' => 'ChamadosController@create', 'middleware' => 'auth']);
Route::post('/chamados/cadastrar', ['uses' => 'ChamadosController@store', 'middleware' => 'auth']);
Route::get('/chamados/responder/{id}', ['as' => 'responder-chamado-usuario', 'uses' => 'ChamadosController@edit', 'middleware' => 'auth']);
Route::post('/chamados/responder/{id}', ['as' => 'responder-chamado-usuario', 'uses' => 'ChamadosController@update', 'middleware' => 'auth']);
Route::get('/acessar', ['as' => 'acessar', 'uses' => 'HomeController@acessar', 'middleware' => 'guest']);
Route::post('/acessar', ['as' => 'acessar', 'uses' => 'HomeController@checkEmail']);
//Route::get('/register', ['as' => 'register', 'uses' => 'HomeController@register']);

Route::get('/apuracoes', ['as' => 'listar-processos', 'uses' => 'ProcessoController@indexUsuario', 'middleware' => 'auth']);
Route::get('/apuracoes/abrir/{competencia}/{id_imposto}/{cnpj}/{vencimento}', ['as' => 'abrir-processo', 'uses' => 'ProcessoController@create', 'middleware' => 'auth'])->where('cnpj', '(.*)');
Route::post('/apuracoes/cadastrar', ['as' => 'criar-processo', 'uses' => 'ProcessoController@store', 'middleware' => 'auth']);
Route::post('/apuracoes/enviar_informacoes/{id}', ['as' => 'enviar-informacoes-processo', 'uses' => 'ProcessoController@store', 'middleware' => 'auth']);
Route::get('/apuracoes/responder/{id}', ['as' => 'responder-processo-usuario', 'uses' => 'ProcessoController@editUsuario', 'middleware' => 'auth']);
Route::post('/apuracoes/responder/{id}', ['as' => 'responder-processo-usuario', 'uses' => 'ProcessoController@update', 'middleware' => 'auth']);

Route::get('/usuario', ['as' => 'editar-usuario', 'uses' => 'UsuarioController@edit', 'middleware' => 'auth']);
Route::post('/usuario', ['uses' => 'UsuarioController@update', 'middleware' => 'auth']);

// Empresa routes...
Route::get('/empresas', ['as' => 'empresas', 'uses' => 'EmpresaController@index', 'middleware' => 'auth']);
Route::get('/empresas/cadastrar', ['as' => 'cadastrar-empresa', 'uses' => 'EmpresaController@create', 'middleware' => 'auth']);
Route::post('/empresas/cadastrar', ['uses' => 'EmpresaController@store', 'middleware' => 'auth']);
Route::get('/empresas/editar/{id}', ['as' => 'editar-empresa', 'uses' => 'EmpresaController@edit', 'middleware' => 'auth']);
Route::post('/empresas/editar/{id}', ['uses' => 'EmpresaController@update', 'middleware' => 'auth']);

Route::get('/admin/empresas', ['as' => 'empresas-admin', 'uses' => 'EmpresaController@indexAdmin', 'middleware' => 'admin']);
Route::get('/admin/empresas/editar/{id}', ['as' => 'editar-empresa-admin', 'uses' => 'EmpresaController@editAdmin', 'middleware' => 'admin']);

Route::get('/abertura-empresa', ['as' => 'abertura-empresa', 'uses' => 'AberturaEmpresaController@index', 'middleware' => 'auth']);
Route::get('/abertura-empresa/cadastrar', ['as' => 'cadastrar-abertura-empresa', 'uses' => 'AberturaEmpresaController@create', 'middleware' => 'auth']);
Route::post('/abertura-empresa/cadastrar', ['uses' => 'AberturaEmpresaController@store', 'middleware' => 'auth']);
Route::get('/abertura-empresa/editar/{id}', ['as' => 'editar-abertura-empresa', 'uses' => 'AberturaEmpresaController@edit', 'middleware' => 'auth']);
Route::post('/abertura-empresa/editar/{id}', ['uses' => 'AberturaEmpresaController@update', 'middleware' => 'auth']);

// Registration routes...
Route::get('/registrar', ['uses' => 'Auth\AuthController@getRegister', 'as' => 'registrar']);
Route::post('/registrar', ['uses' => 'Auth\AuthController@postRegister', 'as' => 'registrar']);

//Login routes...
Route::get('/login', ['uses' => 'Auth\AuthController@getLogin', 'as' => 'login']);
Route::post('/login', ['uses' => 'Auth\AuthController@postLogin', 'as' => 'login']);


Route::get('/curl', ['uses' => 'HomeController@curl', 'as' => 'curl']);


Route::post('/chat/novo', ['uses' => 'ChatController@storeAjax', 'as' => 'novo-chat']);
Route::post('/chat/atualiza-mensagens', ['uses' => 'ChatController@getMensagensAjax', 'as' => 'atualiza-mensagens-chat']);
Route::post('/chat/envia-mensagem', ['uses' => 'ChatController@updateAjax', 'as' => 'envia-mensagem-chat']);


Route::get('/sair', ['uses' => 'Auth\AuthController@getLogout', 'as' => 'sair']);

Route::controllers([
    'password' => 'Auth\PasswordController',
]);

Route::get('/ajax/simular-plano/', ['as' => 'ajax-simular-plano', 'uses' => 'PlanoController@simular']);
Route::post('/ajax/consulta/', ['as' => 'ajax-simples', 'uses' => 'DashboardController@consultaAjax', 'middleware' => 'auth']);
Route::post('/ajax/validar-socio/', ['as' => 'ajax-validar-socio', 'uses' => 'AberturaEmpresaController@validateSocio', 'middleware' => 'auth']);
Route::post('/ajax/cnae/', ['as' => 'ajax-cnae', 'uses' => 'CnaeController@ajax', 'middleware' => 'auth']);
Route::post('/ajax/calendar/', ['as' => 'ajax-calendar', 'uses' => 'ImpostoController@ajaxCalendar', 'middleware' => 'auth']);
Route::get('/ajax/instrucoes/', ['as' => 'ajax-instrucoes', 'uses' => 'ImpostoController@ajaxInstrucoes', 'middleware' => 'auth']);
Route::post('/ajax/enviar-contato/', ['as' => 'ajax-enviar-contato', 'uses' => 'HomeController@ajaxContato']);


Route::get('/ajax/enviar-contat2o', ['as' => 'ajax2-enviar-contato', 'uses' => function () {
        $user = App\Usuario::findOrFail(2);
        Mail::send('emails.novo-usuario', ['nome' => $user->nome], function ($m) use ($user) {
            $m->to($user->email, $user->nome)->subject('Bem Vindo à WEBContabilidade');
        });
    }]);
        