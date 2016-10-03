@extends('layouts.admin')
@section('main')
<h1>Natureza Jurídica</h1>
<hr class="dash-title">
<table class='table'>
    <thead>
        <tr>
            <th>Descrição</th>
            <th>Representante</th>
            <th>Qualificação</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @if($naturezas_juridicas->count())
        @foreach($naturezas_juridicas as $natureza_juridica)
        <tr>
            <td>{{$natureza_juridica->descricao}}</td>
            <td>{{$natureza_juridica->representante}}</td>
            <td>{{$natureza_juridica->qualificacao}}</td>
            <td><a class="btn btn-warning" href="{{route('editar-natureza-juridica', ['id' => $natureza_juridica->id])}}">Editar</a> <a class="btn btn-danger" href="{{$natureza_juridica->id}}">Remover</a></td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="2">Nenhum registro cadastrado</td>
        </tr>
        @endif
    </tbody>
</table>

<a class='btn btn-primary' href='{{route('cadastrar-natureza-juridica')}}'>Cadastrar uma natureza jurídica</a><br />

@stop