@extends('layouts.dashboard')
@section('js')
@parent
<script type="text/javascript">
$(function(){
});
</script>
@stop
@section('main')
<h1>Início</h1>
@if(Auth::user()->pessoas->count() > 0)
<div>aaaaaaaaaaaaaaaaaaaaaa121</div>
@else
<div>aaaaaaaaaaaaaaaaaaaaaa</div>
@endif
<hr class="dash-title">
<div class="col-lg-7 col-md-12"><div class="hidden-lg">Olá, no calendário abaixo se encontram os impostos que você deve pagar para suas empresa.<br /> Para verificar como pagar, clique no imposto desejado.</div><br /><div id="calendar"></div></div>
<div class="col-lg-5 col-md-12" id="instrucao"><div class="visible-lg">Olá, no calendário ao lado se encontram os impostos que você deve pagar para suas empresas.<br /> Para verificar como pagar, clique no imposto desejado.</div></div>

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

