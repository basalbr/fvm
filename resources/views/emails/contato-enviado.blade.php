@extends('layouts.email')
@section('main')
<div class="col-xs-12">
    <div class="corpo-email">
        <h1>Mensagem recebida</h1>
        <hr>
        <p>Olá {{$nome}}, estamos enviando esse e-mail para confirmar que recebemos sua mensagem.</p>
        <p>Nossa equipe já está analisando sua mensagem e em breve retornaremos seu contato.</p>
        <p>A equipe <b>WEBContabilidade</b> agradece sua preferência!</p>
        <div class="text-right"><a target="_blank" href="{{route('home')}}"><img src="{{url('images/logotipo-pequeno.png')}}" /></a></div>    
    </div>
    
</div>
@stop