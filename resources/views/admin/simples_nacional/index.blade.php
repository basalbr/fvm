@extends('layouts.admin')
@section('main')
<h1>Tabela do Simples Nacional</h1>
<hr class="dash-title">
<table class='table'>
    <thead>
        <tr>
            <th>Descrição</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @if($tabelas->count())
        @foreach($tabelas as $tabela)
        <tr>
            <td>{{$tabela->descricao}}</td>
            <td><a class="btn btn-warning" href="{{route('editar-simples-nacional', ['id' => $tabela->id])}}">Editar</a> <a class="btn btn-danger" href="{{$tabela->id}}">Remover</a></td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="2">Nenhum registro cadastrado</td>
        </tr>
        @endif
    </tbody>
</table>
<a class='btn btn-primary' href='{{route('cadastrar-simples-nacional')}}'>Cadastrar uma tabela do simples nacional</a><br />

@stop