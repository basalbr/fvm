@extends('layouts.email')
@section('main')
<div class="col-xs-12">
   <div class="corpo-email">
        <h1>Nova Apuração de Imposto</h1>
        <hr>
        <p>Olá, {{$nome}} possui uma nova apuração.</p>
        <p>Para acompanhar a apuração, <a href="{{route('visualizar-processo-admin', ['id' => $id_processo])}}">clique aqui</a>.</p>
        <div class="text-right"><a target="_blank" href="{{route('home')}}"><img src="{{url('images/logotipo-pequeno.png')}}" /></a></div>    
    </div>
    
</div>
@stop