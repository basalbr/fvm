@extends('layouts.master')
@section('header_title', 'Home')
@section('content')
<section id='page-header' style="margin-top: 55px" class="page-header">
    <div class='container'>
        <h1>Sistema</h1>
    </div>
</section>
<section>
    <div class="container">
        @if(!Auth::user()->pessoas->count())
        <p>Você não possui nenhuma empresa cadastrada, você precisa possuir pelo menos uma empresa cadastrada para poder utilizar nosso sistema.<br />
            @endif
            <a href='{{route('cadastrar-empresa')}}'>Clique aqui para cadastrar uma empresa agora mesmo!</a></p>
        <a href='{{route('cadastrar-chamado')}}'>Abrir chamado!</a>
        <a href='{{route('listar-chamados-usuario')}}'>Visualizar chamados!</a>
        <div id="calendar"></div>
    </div>
</section>
@stop