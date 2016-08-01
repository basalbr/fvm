@extends('layouts.dashboard')
@section('header_title', 'Chamados')
@section('main')
<h1>Chamados</h1>
<hr class="dash-title">
<table class='table'>
    <thead>
        <tr>
            <th>Data</th>
            <th>Título</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @if($chamados->count())
        @foreach($chamados as $chamado)
        <tr>
            <td>{{$chamado->updated_at}}</td>
            <td>{{$chamado->titulo}}</td>
            <td><a href="{{route('responder-chamado-usuario', ['id' => $chamado->id])}}">Responder</a></td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="3">Nenhum registro cadastrado</td>
        </tr>
        @endif
    </tbody>
</table>
<a class='btn btn-primary' href='{{route('cadastrar-chamado')}}'>Abrir chamado</a><br />

@stop