@extends('layouts.email')
@section('main')
<div class="col-xs-12">
    <div class="corpo-email">
        <h1>Mudança de Status em Apuração</h1>
        <hr>
        <p>Olá {{$nome}}, estamos enviando esse e-mail para informar que a apuração de {{$imposto}} teve o status alterado para: <strong>{{$status}}</strong>.</p>
        <p>Para acompanhar a apuração, <a href="{{route('responder-processo-usuario', ['id' => $id_processo])}}">clique aqui</a>.</p>
        <p>A equipe <b>WEBContabilidade</b> agradece sua preferência!</p>
        <div class="text-right"><a target="_blank" href="{{route('home')}}"><img src="{{url('images/logotipo-pequeno.png')}}" /></a></div>    
    </div>
    
</div>
@stop