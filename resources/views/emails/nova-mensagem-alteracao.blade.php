@extends('layouts.email')
@section('main')
<div class="col-xs-12">
    <div class="corpo-email">
        <h1>Solicitação de Alteração</h1>
        <hr>
        <p>Olá {{$nome}}, estamos enviando esse e-mail para avisar que você recebeu uma nova mensagem em sua solicitação de alteração.</p>
        <p>Para visualizar a mensagem, <a href="{{route('editar-solicitacao-alteracao', [$id_empresa, $id_alteracao])}}">clique aqui</a>.</p>
        <p>A equipe <b>WEBContabilidade</b> agradece sua preferência!</p>
        <div class="text-right"><a target="_blank" href="{{route('home')}}"><img src="{{url('images/logotipo-pequeno.png')}}" /></a></div>    
    </div>
    
</div>
@stop