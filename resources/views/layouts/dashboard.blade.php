@extends('layouts.master')
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
        <li class='{{Request::is('empresas*') ? "active" : ""}}'>
            <a href="{{route('empresas')}}"><div class="icon"><span class="fa fa-building"></span></div>Empresas</a>
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
    @yield('modal')
</div>
@overwrite