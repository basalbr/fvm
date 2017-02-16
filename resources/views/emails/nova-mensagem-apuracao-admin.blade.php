@extends('layouts.email')
@section('main')
<div class="col-xs-12">
    <div class="corpo-email">
        <h1>Nova mensagem em apuração</h1>
        <hr>
        <p>Existe uma nova mensagem de {{$nome_fantasia}} na apuração de {{$apuracao}}.</p>
        <p>Para visualizar a mensagem, <a href="{{route('visualizar-processo-admin', ['id' => $id_processo])}}">clique aqui</a>.</p>
        <div class="text-right"><a target="_blank" href="{{route('home')}}"><img src="{{url('images/logotipo-pequeno.png')}}" /></a></div>
    </div>
    
</div>
@stop