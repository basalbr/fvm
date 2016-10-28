@extends('layouts.email')
@section('main')
<div class="col-xs-12">
   <div class="corpo-email">
        <h1>Novo Chamado</h1>
        <hr>
        <p>Olá, {{$nome}} abriu um novo chamado.</p>
        <p>Para acompanhar o chamado, <a href="{{route('visualizar-chamados', ['id' => $id_chamado])}}">clique aqui</a>.</p>
        <div class="text-right"><a target="_blank" href="{{route('home')}}"><img src="{{url('images/logotipo-pequeno.png')}}" /></a></div>    
    </div>
    
</div>
@stop