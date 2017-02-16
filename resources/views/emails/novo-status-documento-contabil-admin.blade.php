@extends('layouts.email')
@section('main')
<div class="col-xs-12">
    <div class="corpo-email">
        <h1>Mudança de Status de Processo de Envio de Documentos Contábeis</h1>
        <hr>
        <p>Um processo de envio de documentos contábeis teve uma mudança de status.</p>
        <p>Para acompanhar o processo, <a href="{{route('listar-documento-contabil-admin', ['id' => $id_processo])}}">clique aqui</a>.</p>
        <div class="text-right"><a target="_blank" href="{{route('home')}}"><img src="{{url('images/logotipo-pequeno.png')}}" /></a></div>    
    </div>
    
</div>
@stop