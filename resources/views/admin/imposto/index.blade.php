@extends('layouts.admin')
@section('main')
<h1>Imposto</h1>
<hr class="dash-title">
<table class='table'>
    <thead>
        <tr>
            <th>Nome</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @if($impostos->count())
        @foreach($impostos as $imposto)
        <tr>
            <td>{{$imposto->nome}}</td>
            <td><a class="btn btn-info" href="{{route('listar-instrucao', ['id' => $imposto->id])}}">Instruções</a> <a class="btn btn-primary" href="{{route('listar-informacao-extra', ['id' => $imposto->id])}}">Informações Extras</a> <a class="btn btn-warning" href="{{route('editar-imposto', ['id' => $imposto->id])}}">Editar</a> <a class="btn btn-danger" href="{{$imposto->id}}">Remover</a></td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="2">Nenhum registro cadastrado</td>
        </tr>
        @endif
    </tbody>
</table>
<a class='btn btn-primary' href='{{route('cadastrar-imposto')}}'>Cadastrar um imposto</a><br />

@stop