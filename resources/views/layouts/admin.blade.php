@extends('layouts.master')
@section('content')
<div id="sidebar-left">
    <ul>
        <li class='{{Route::is('admin') ? "active" : ""}}'>
            <a href="{{route('admin')}}"><div class="icon"><span class="fa fa-home"></div></span>Início</a>
        </li>
        <li class='{{Request::is('empresas*') ? "active" : ""}}'>
            <a href="{{route('empresas')}}"><div class="icon"><span class="fa fa-building"></div>Empresas</a>
        </li>
        <li class='{{Request::is('chamados*') ? "active" : ""}}'>
            <a href="{{route('listar-chamados')}}"><div class="icon"><span class="fa fa-envelope"></div>Chamados</a>
        </li>
        <li class='{{Request::is('cnae*') ? "active" : ""}}'>
            <a href="{{route('listar-cnae')}}"><div class="icon"><span class="fa fa-envelope"></div>CNAEs</a>
        </li>
        <li class='{{Request::is('imposto*') ? "active" : ""}}'>
            <a href="{{route('listar-imposto')}}"><div class="icon"><span class="fa fa-envelope"></div>Impostos</a>
        </li>
        <li class='{{Request::is('natureza-juridica*') ? "active" : ""}}'>
            <a href="{{route('listar-natureza-juridica')}}"><div class="icon"><span class="fa fa-envelope"></div>Nat. Jurídica</a>
        </li>
        <li class='{{Request::is('plano*') ? "active" : ""}}'>
            <a href="{{route('listar-plano')}}"><div class="icon"><span class="fa fa-envelope"></div>Planos</a>
        </li>
        <li class='{{Request::is('simples-nacional*') ? "active" : ""}}'>
            <a href="{{route('listar-simples-nacional')}}"><div class="icon"><span class="fa fa-envelope"></div>Simples Nacional</a>
        </li>
         <li class='{{Request::is('tipo-tributacao*') ? "active" : ""}}'>
            <a href="{{route('listar-tipo-tributacao')}}"><div class="icon"><span class="fa fa-envelope"></div>Tip. Tributação</a>
        </li>
    </ul>
</div>
<div id="dash-container" class='bg-ltblue'>
    <div class="container-fluid bg-white">
        @yield('main')
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
</div>
@overwrite