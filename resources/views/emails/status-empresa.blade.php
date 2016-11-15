@extends('layouts.email')
@section('main')
<div class="col-xs-12">
    <div class="corpo-email">
        <h1>Status {{$nome_empresa}} alterado para {{$status}}</h1>
        <hr>
        <p>Olá {{$nome}}, estamos enviando esse e-mail porque o status da empresa {{$nome_empresa}} foi alterado para {{$status}}.</p>
        <p>Caso você tenha alguma dúvida, acesse nosso site e crie um novo chamado. Ficaremos felizes em tirar qualquer dúvida que você possa ter.</p>
        <p>Para acessar nosso sistema, basta clicar <a target="_blank" href="{{route('acessar')}}">nesse link</a>.</p>
        <p>A equipe <b>WEBContabilidade</b> agradece sua preferência!</p>
        <div class="text-right"><a target="_blank" href="{{route('home')}}"><img src="{{url('images/logotipo-pequeno.png')}}" /></a></div>    
    </div>
    
</div>
@stop