@extends('layouts.admin')
@section('main')

<h1>Chamados</h1>
<hr class="dash-title">

<table class='table'>
    <thead>
        <tr>
            <th>Data</th>
            <th>Título</th>
            <th>Usuário</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @if($chamados->count())
        @foreach($chamados as $chamado)
        <tr>
            <td>{{$chamado->updated_at}}</td>
            <td>{{$chamado->titulo}}</td>
            <td>{{$chamado->usuario->nome}}</td>
            <td><a class="btn btn-info" href="{{route('visualizar-chamados', ['id' => $chamado->id])}}">Responder</a></td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="2">Nenhum registro cadastrado</td>
        </tr>
        @endif
    </tbody>
</table>

@stop
@section('header_title', 'Chamados')
