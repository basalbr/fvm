@extends('layouts.master')
@section('content')
<div id="sidebar-left">
    <ul>
        <li class='{{Route::is('admin') ? "active" : ""}}'>
            <a href="{{route('admin')}}"><div class="icon"><span class="fa fa-home"></div></span>Início</a>
        </li>
<!--        <li class='{{Request::is('empresas*') ? "active" : ""}}'>
            <a href="{{route('empresas')}}"><div class="icon"><span class="fa fa-building"></div>Empresas</a>
        </li>-->
        <li class='{{Request::is('admin/chamados*') ? "active" : ""}}'>
            <a href="{{route('listar-chamados')}}"><div class="icon"><span class="fa fa-envelope"></div>Chamados</a>
        </li>
        <li class='{{Request::is('admin/cnae*') ? "active" : ""}}'>
            <a href="{{route('listar-cnae')}}"><div class="icon"><span class="fa fa-industry"></div>CNAEs</a>
        </li>
        <li class='{{Request::is('admin/imposto*') ? "active" : ""}}'>
            <a href="{{route('listar-imposto')}}"><div class="icon"><span class="fa fa-money"></div>Impostos</a>
        </li>
        <li class='{{Request::is('admin/natureza-juridica*') ? "active" : ""}}'>
            <a href="{{route('listar-natureza-juridica')}}"><div class="icon"><span class="fa fa-legal"></div>Nat. Jurídica</a>
        </li>
        <li class='{{Request::is('admin/plano*') ? "active" : ""}}'>
            <a href="{{route('listar-plano')}}"><div class="icon"><span class="fa fa-shopping-cart"></div>Planos</a>
        </li>
        <li class='{{Request::is('admin/simples-nacional*') ? "active" : ""}}'>
            <a href="{{route('listar-simples-nacional')}}"><div class="icon"><span class="fa fa-table"></div>Simples Nacional</a>
        </li>
         <li class='{{Request::is('admin/tipo-tributacao*') ? "active" : ""}}'>
            <a href="{{route('listar-tipo-tributacao')}}"><div class="icon"><span class="fa fa-sitemap"></div>Tip. Tributação</a>
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