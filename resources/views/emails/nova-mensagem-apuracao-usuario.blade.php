@extends('layouts.email')
@section('main')
    <div class="col-xs-12">
        <div class="corpo-email">
            <h1>Nova mensagem em apuração</h1>
            <hr>
            <p>Olá {{$nome}}, existe uma nova mensagem na apuração de {{$apuracao}}.</p>
            <p>Para visualizar a mensagem, <a href="{{route('responder-processo-usuario', ['id' => $id_processo])}}">clique aqui</a>.</p>
            <p>A equipe <b>WEBContabilidade</b> agradece sua preferência!</p>
            <div class="text-right"><a target="_blank" href="{{route('home')}}"><img src="{{url('images/logotipo-pequeno.png')}}" /></a></div>
        </div>

    </div>
@stop
