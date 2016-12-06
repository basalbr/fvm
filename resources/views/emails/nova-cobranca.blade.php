@extends('layouts.email')
@section('main')
<div class="col-xs-12">
   <div class="corpo-email">
        <h1>Nova Cobrança</h1>
        <hr>
        <p>Olá, existe uma nova cobrança de {{$valor}} para {{$nome}}.</p>
        <p>Para visualizar, <a href="{{route('listar-pagamentos-pendentes')}}">clique aqui.</a>.</p>
        <div class="text-right"><a target="_blank" href="{{route('home')}}"><img src="{{url('images/logotipo-pequeno.png')}}" /></a></div>    
    </div>
    
</div>
@stop