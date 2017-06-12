@extends('layouts.email')
@section('main')
<div class="col-xs-12">
    <div class="corpo-email">
        <h1>Envio de Documentos Contábeis</h1>
        <hr>
        <p>Olá {{$nome}}, estamos enviando esse e-mail para informar que você deve nos enviar seus documentos contábeis.</p>
        <p>Para enviar os documentos,<a href="{{route('listar-processo-documento-contabil')}}">clique aqui</a>.</p>
        <p>A equipe <b>WEBContabilidade</b> agradece sua preferência!</p>
        <div class="text-right"><a target="_blank" href="{{route('home')}}"><img src="{{url('images/logotipo-pequeno.png')}}" /></a></div>    
    </div>
    
</div>
@stop