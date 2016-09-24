@extends('layouts.email')
@section('main')
<div class="col-xs-12">
    <div class="corpo-email">
        <h1>Nova Empresa Cadastrada</h1>
        <hr>
        <p>Olá {{$nome}}, estamos enviando esse e-mail porque você cadastrou a empresa {{$empresa->nome_fantasia}} em nosso sistema.</p>
        <p>Para acessar nosso sistema, basta clicar <a target="_blank" href="{{route('acessar')}}">nesse link</a>.</p>
        <p>A equipe <b>WEBContabilidade</b> agradece sua preferência!</p>
        <div class="text-right"><a target="_blank" href="{{route('home')}}"><img src="{{url('images/logotipo-pequeno.png')}}" /></a></div>    
    </div>
    
</div>
@stop