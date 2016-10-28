@extends('layouts.email')
@section('main')
<div class="col-xs-12">
    <div class="corpo-email">
        <h1>Nova Solicitação de Abertura de Empresa</h1>
        <hr>
        <p>Olá, {{$nome}} solicitou uma nova abertura de empresa.</p>
        <p>Para acompanhar o processo de abertura de empresa, <a href="{{route('editar-abertura-empresa-admin', ['id' => $id_empresa])}}">clique aqui</a>.</p>
        <div class="text-right"><a target="_blank" href="{{route('home')}}"><img src="{{url('images/logotipo-pequeno.png')}}" /></a></div>    
    </div>
    
</div>
@stop