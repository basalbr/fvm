@extends('layouts.email')
@section('main')
<div class="col-xs-12">
    <div class="corpo-email">
        <h1>Novo Funcionário Cadastrado</h1>
        <hr>
        <p>{{$usuario}} cadastrou um novo funcionário no sistema.</p>
        <p><b>Empresa:</b>{{$empresa}}.</p>
        <p><b>Funcionário:</b>{{$funcionario}}.</p>
        <p>Para visualizar o novo funcionário, clique <a target="_blank" href="{{route('editar-funcionario-admin', [$id_funcionario])}}">nesse link</a>.</p>
        <p>A equipe <b>WEBContabilidade</b> agradece sua preferência!</p>
        <div class="text-right"><a target="_blank" href="{{route('home')}}"><img src="{{url('images/logotipo-pequeno.png')}}" /></a></div>    
    </div>
    
</div>
@stop