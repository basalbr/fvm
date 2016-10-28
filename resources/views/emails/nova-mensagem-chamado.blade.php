@extends('layouts.email')
@section('main')
<div class="col-xs-12">
    <div class="corpo-email">
        <h1>Nova Mensagem</h1>
        <hr>
        <p>Olá {{$nome}}, estamos enviando esse e-mail para avisar que você recebeu uma nova mensagem em seu chamado.</p>
        <p>Para acompanhar o chamado, <a href="{{route('responder-chamado-usuario', ['id' => $id_chamado])}}">clique aqui</a>.</p>
        <p>A equipe <b>WEBContabilidade</b> agradece sua preferência!</p>
        <div class="text-right"><a target="_blank" href="{{route('home')}}"><img src="{{url('images/logotipo-pequeno.png')}}" /></a></div>    
    </div>
    
</div>
@stop