@extends('layouts.email')
@section('main')
<div class="col-xs-12">
    <div class="corpo-email">
        <h1>Solicitação de Abertura de Empresa</h1>
        <hr>
        <p>Olá {{$nome}}, estamos enviando esse e-mail para avisar que você recebeu uma nova mensagem em sua solicitação de abertura de empresa.</p>
        <p>Para acompanhar visualizar a mensagem, <a href="{{route('editar-abertura-empresa', ['id' => $id_empresa])}}">clique aqui</a>.</p>
        <p>A equipe <b>WEBContabilidade</b> agradece sua preferência!</p>
        <div class="text-right"><a target="_blank" href="{{route('home')}}"><img src="{{url('images/logotipo-pequeno.png')}}" /></a></div>    
    </div>
    
</div>
@stop