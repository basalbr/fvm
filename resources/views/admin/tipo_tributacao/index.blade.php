@extends('layouts.admin')
@section('main')
<h1>Tipo de Tributação</h1>
<hr class="dash-title">
<table class='table'>
    <thead>
        <tr>
            <th>Descrição</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @if($tipo_tributacao->count())
        @foreach($tipo_tributacao as $tipo)
        <tr>
            <td>{{$tipo->descricao}}</td>
            <td><a href="{{route('editar-tipo-tributacao', ['id' => $tipo->id])}}" class="btn btn-warning"><span class="fa fa-pencil"></span> Editar</a> <a href="{{$tipo->id}}" class="btn btn-danger"><span class="fa fa-remove"></span> Remover</a></td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="2">Nenhum registro cadastrado</td>
        </tr>
        @endif
    </tbody>
</table>
<a class='btn btn-primary' href='{{route('cadastrar-tipo-tributacao')}}'>Cadastrar um tipo de tributação</a><br />

@stop