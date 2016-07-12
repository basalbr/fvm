@extends('layouts.dashboard')
@section('main')
<h1>Início</h1>
<hr class="dash-title">
<div class="col-md-7"><div id="calendar"></div></div>
<div class="col-md-5">Olá, no calendário ao lado se encontram os impostos que você deve pagar para suas empresas.<br /> Para verificar como pagar, clique no imposto desejado.</div>

@stop
@section('header_title', 'Início')
<!--@section('content')-->
<!--<section id='page-header' style="margin-top: 55px" class="page-header">
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
@stop-->

