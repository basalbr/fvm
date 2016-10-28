@extends('layouts.email')
@section('main')
<div class="col-xs-12">
    <div class="corpo-email">
        <h1>Solicitação de Abertura de Empresa</h1>
        <hr>
        <p>Olá {{$nome}}, estamos enviando esse e-mail para informar que concluímos sua solicitação de abertura da empresa <b>{{$empresa}}</b>.</p>
        <p>A equipe <b>WEBContabilidade</b> agradece sua preferência!</p>
        <div class="text-right"><a target="_blank" href="{{route('home')}}"><img src="{{url('images/logotipo-pequeno.png')}}" /></a></div>    
    </div>
    
</div>
@stop