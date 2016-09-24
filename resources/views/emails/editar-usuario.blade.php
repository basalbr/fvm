@extends('layouts.email')
@section('main')
<div class="col-xs-12">
    <div class="corpo-email">
        <h1>Seus dados foram alterados</h1>
        <hr>
        <p>Olá {{$nome}}, estamos enviando esse e-mail porque você alterou seus dados em nosso sistema.</p>
        <p>Caso você não tenha feito isso, acesse nosso site e envie uma mensagem nos alertando sobre essa situação.</p>
        <p>Para acessar nosso sistema, basta clicar <a target="_blank" href="{{route('acessar')}}">nesse link</a>.</p>
        <p>A equipe <b>WEBContabilidade</b> agradece sua preferência!</p>
        <div class="text-right"><a target="_blank" href="{{route('home')}}"><img src="{{url('images/logotipo-pequeno.png')}}" /></a></div>    
    </div>
    
</div>
@stop