@extends('layouts.email')
@section('main')
<div class="col-xs-12">
    <div class="corpo-email">
        <h1>Nova Solicitação de Alteração</h1>
        <hr>
        <p>Olá {{$nome}}, estamos enviando esse e-mail para confirmar que recebemos sua solicitação de alteração: {{$tipo_alteracao}}.</p>
        <p>Nossa equipe já está analisando sua solicitação e em breve retornaremos seu contato.</p>
        <p>Para acompanhar o processo de alteração, <a href="{{route('editar-solicitacao-alteracao', [$id_empresa, $id_solicitacao])}}">clique aqui</a>.</p>
        <p>A equipe <b>WEBContabilidade</b> agradece sua preferência!</p>
        <div class="text-right"><a target="_blank" href="{{route('home')}}"><img src="{{url('images/logotipo-pequeno.png')}}" /></a></div>    
    </div>
    
</div>
@stop