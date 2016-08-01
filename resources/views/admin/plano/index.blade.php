@extends('layouts.admin')
@section('main')

<h1>Planos de Pagamento</h1>
<hr class="dash-title">
<table class='table'>
    <thead>
        <tr>
            <th>Nome</th>
            <th>Duração</th>
            <th>Valor</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @if($planos->count())
        @foreach($planos as $plano)
        <tr>
            <td>{{$plano->nome}}</td>
            <td>{{$plano->duracao}}</td>
            <td>{{$plano->valor}}</td>
            <td><a class="btn btn-warning" href="{{route('editar-plano', ['id' => $plano->id])}}">Editar</a> <a class="btn btn-danger" href="{{$plano->id}}">Remover</a></td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="2">Nenhum registro cadastrado</td>
        </tr>
        @endif
    </tbody>
</table>
<a class='btn btn-primary' href='{{route('cadastrar-plano')}}'>Cadastrar um plano de pagamento</a><br />

@stop