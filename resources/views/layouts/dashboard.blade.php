@extends('layouts.master')
@section('content')
<div id="sidebar-left">
    <ul>
        <li class='{{Route::is('dashboard') ? "active" : ""}}'>
            <a href="{{route('dashboard')}}"><div class="icon"><span class="fa fa-home"></div></span>Início</a>
        </li>
        <li class='{{Request::is('empresas*') ? "active" : ""}}'>
            <a href="{{route('empresas')}}"><div class="icon"><span class="fa fa-building"></div>Empresas</a>
        </li>
        <li class='{{Request::is('chamados*') ? "active" : ""}}'>
            <a href="{{route('listar-chamados-usuario')}}"><div class="icon"><span class="fa fa-envelope"></div>Chamados</a>
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