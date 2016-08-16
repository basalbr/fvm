@extends('layouts.admin')
@section('main')
<h1>CNAE</h1>
<hr class="dash-title">
<a class='btn btn-primary' href='{{route('cadastrar-cnae')}}'>Cadastrar um CNAE</a><br />
<br />
<table class='table'>
    <thead>
        <tr>
            <th>Descrição</th>
            <th>Código</th>
            <th>Tabela do simples nacional</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @if($cnaes->count())
        @foreach($cnaes as $cnae)
        <tr>
            <td>{{$cnae->descricao}}</td>
            <td>{{$cnae->codigo}}</td>
            <td>{{$cnae->tabela_simples_nacional ? $cnae->tabela_simples_nacional->descricao : null}}</td>
            <td><a href="{{route('editar-cnae', ['id' => $cnae->id])}}" class="btn btn-warning">Editar</a> <a class="btn btn-danger" href="{{$cnae->id}}">Remover</a></td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="2">Nenhum registro cadastrado</td>
        </tr>
        @endif
    </tbody>
</table>
{!! str_replace('/?', '?', $cnaes->render()) !!}
<!--@include('pagination.default', ['paginator' => $cnaes])-->
<div class="clear"></div>
<a class='btn btn-primary' href='{{route('cadastrar-cnae')}}'>Cadastrar um CNAE</a><br />

@stop