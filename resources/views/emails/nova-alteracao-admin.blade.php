@extends('layouts.email')
@section('main')
<div class="col-xs-12">
    <div class="corpo-email">
        <h1>Nova Solicitação de Alteração</h1>
        <hr>
        <p>Olá, {{$nome}} solicitou uma nova solicitação de alteração.</p>
        <p>Para acompanhar o processo de solicitação de alteração, <a href="{{route('visualizar-solicitacao-alteracao-admin', ['id' => $id_alteracao])}}">clique aqui</a>.</p>
        <div class="text-right"><a target="_blank" href="{{route('home')}}"><img src="{{url('images/logotipo-pequeno.png')}}" /></a></div>    
    </div>
    
</div>
@stop