@extends('layouts.email')
@section('main')
<div class="col-xs-12">
    <div class="corpo-email">
        <h1>Mudança de Status de Processo de Envio de Documentos Contábeis</h1>
        <hr>
        <p>Olá {{$nome}}, estamos enviando esse e-mail para informar que um processo de envio de documentos contábeis teve uma mudança de status.</p>
        <p>Para acompanhar o processo, <a href="{{route('listar-documento-contabil', ['id' => $id_processo])}}">clique aqui</a>.</p>
        <p>A equipe <b>WEBContabilidade</b> agradece sua preferência!</p>
        <div class="text-right"><a target="_blank" href="{{route('home')}}"><img src="{{url('images/logotipo-pequeno.png')}}" /></a></div>    
    </div>
    
</div>
@stop