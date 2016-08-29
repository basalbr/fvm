@extends('layouts.admin')
@section('main')
<h1>Instruções de {{$imposto->nome}}</h1>
<hr class="dash-title">

    <table class='table'>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Tipo</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if($imposto->informacoes_extras()->count())
            @foreach($imposto->informacoes_extras()->orderBy('nome')->get() as $informacao_extra)
            <tr>
                <td>{{$informacao_extra->nome}}</td>
                <td>{{$informacao_extra->tipo}}</td>
                <td><a class="btn btn-warning" href="{{route('editar-informacao', ['id_imposto' =>$imposto->id,'id_informacao' => $informacao_extra->id])}}">Editar</a> <a class="btn btn-danger" href="{{$informacao_extra->id}}">Remover</a></td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="3">Nenhum registro cadastrado</td>
            </tr>
            @endif
        </tbody>
    </table>
    <a class='btn btn-primary' href='{{route('cadastrar-informacao-extra',['id_imposto' =>$imposto->id])}}'>Cadastrar uma informação extra</a><br />

    @stop