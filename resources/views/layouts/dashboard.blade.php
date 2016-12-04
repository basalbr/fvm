@extends('layouts.master')
@section('js')
@parent
<script type='text/javascript'>
$(function(){
            $('.remover-registro').on('click', function(e){
               e.preventDefault();
               $('#remove-register').attr('href',$(this).attr('href'));
               $('#remover-modal').modal('show');
            });
});
</script>
@stop
@section('content')
<div id="sidebar-left">
    <ul>
        <li class="sidebar-header">
            Central do Cliente
        </li>
        <li class='{{Route::is('dashboard') ? "active" : ""}}'>
            <a href="{{route('dashboard')}}"><div class="icon"><span class="fa fa-home"></div></span>Início</a>
        </li>
        <li class='{{Request::is('chamados*') ? "active" : ""}}'>
            <a href="{{route('listar-chamados-usuario')}}"><div class="icon"><span class="fa fa-envelope"></span></div>Chamados</a>
        </li>
    </ul>
    <ul>
        <li class="sidebar-header">
            Impostos
        </li>
        <li class='{{Request::is('apuracoes*') ? "active" : ""}}'>
            <a href="{{route('listar-processos')}}"><div class="icon"><span class="fa fa-file"></span></div>apurações em aberto</a>
        </li>
        <li class='{{Route::is('calendario') ? "active" : ""}}'>
            <a href="{{route('calendario')}}"><div class="icon"><span class="fa fa-calendar"></span></div>Calendário</a>
        </li>
    </ul>
    <ul>
        <li class="sidebar-header">
            Empresas e Sócios
        </li>
        <li class='{{Request::is('abertura-empresa*') ? "active" : ""}}'>
            <a href="{{route('abertura-empresa')}}"><div class="icon"><span class="fa fa-child"></span></div>Abertura de Empresa</a>
        </li>
        <li class='{{Request::is('empresas*') ? "active" : ""}}'>
            <a href="{{route('empresas')}}"><div class="icon"><span class="fa fa-building"></span></div>Empresas</a>
        </li>
        <li class='{{Request::is('funcionarios*') ? "active" : ""}}'>
            <a href="{{route('funcionarios')}}"><div class="icon"><span class="fa fa-users"></span></div>funcionários</a>
        </li>
        <li class='{{Request::is('socios*') ? "active" : ""}}'>
            <a href="{{route('listar-socios-apenas')}}"><div class="icon"><span class="fa fa-users"></span></div>sócios</a>
        </li>
        <li class='{{Request::is('pro-labore*') ? "active" : ""}}'>
            <a href="{{route('listar-pro-labore-cliente')}}"><div class="icon"><span class="fa fa-dollar"></span></div>pró-labore</a>
        </li>

    </ul>
  <ul>
        <li class="sidebar-header">
            Financeiro
        </li>
        <li class='{{Request::is('mensalidades*') ? "active" : ""}}'>
            <a href="{{route('listar-mensalidades')}}"><div class="icon"><span class="fa fa-book"></span></div>mensalidades ativas</a>
        </li>
        <li class='{{Request::is('pagamentos-pendentes*') ? "active" : ""}}'>
            <a href="{{route('listar-pagamentos-pendentes')}}"><div class="icon"><span class="fa fa-exclamation"></span></div>pagamentos pendentes</a>
        </li>
        <li class='{{Request::is('historico-pagamentos*') ? "active" : ""}}'>
            <a href="{{route('listar-historico-pagamentos')}}"><div class="icon"><span class="fa fa-cart-arrow-down"></span></div>histórico pagamentos</a>
        </li>

    </ul>
    <ul>
        <li class="sidebar-header">
            Configurações
        </li>
        <li class='{{Request::is('usuario*') ? "active" : ""}}'>
            <a href="{{route('editar-usuario')}}"><div class="icon"><span class="fa fa-user"></span></div>editar meus dados</a>
        </li>

    </ul>
  
</div>
<div id="dash-container" class='bg-ltblue'>
    <div class="container-fluid">
        @yield('main')
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
</div>
<div>
    <div class="modal fade" id="remover-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Remover Registro</h4>
                <div class="clearfix"></div>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja remover o registro?</p>
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <a href='' class="btn btn-danger" id='remove-register'>Sim, desejo remover o registro.</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar Janela</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
    @yield('modal')
</div>
@overwrite