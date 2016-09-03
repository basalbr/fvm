@extends('layouts.dashboard')
@section('header_title', 'Processos')
@section('main')
<h1>Processos</h1>
<hr class="dash-title">
<table class='table'>
    <thead>
        <tr>
            <th>Empresa</th>
            <th>Imposto</th>
            <th>Competência</th>
            <th>Aberto em</th>
            <th>Status</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @if($processos->count())
        @foreach($processos as $processo)
        <tr>
            <td>{{$processo->pessoa->nome_fantasia}}</td>
            <td>{{$processo->imposto->nome}}</td>
            <td>{{$processo->competencia}}</td>
            <td>{{$processo->created_at}}</td>
            <td>{{$processo->status}}</td>
            <td><a href="{{route('visualizar-processo-admin', ['id' => $processo->id])}}">Visualizar</a></td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="3">Nenhum registro cadastrado</td>
        </tr>
        @endif
    </tbody>
</table>

@stop