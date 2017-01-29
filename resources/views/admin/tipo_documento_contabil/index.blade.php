@extends('layouts.admin')
@section('header_title', 'Tipos de Documentos Contábeis')
@section('main')
<div class="card">
<h1>Tipos de Documentos Contábeis</h1>

    <h3>Lista de Tipos de Documentos Contábeis</h3>
    <table class='table table-striped table-hover'>
        <thead>
            <tr>
                <th>Descrição</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if($tipos_documentos->count())
            @foreach($tipos_documentos as $tipo)
            <tr>
                <td>{{$tipo->descricao}}</td>
                <td><a href="{{route('editar-tipo-tributacao', ['id' => $tipo->id])}}" class="btn btn-warning"><span class="fa fa-pencil"></span> Editar</a></td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="2">Nenhum registro cadastrado</td>
            </tr>
            @endif
        </tbody>
    </table>

    <div class="clearfix"></div>
    <a class='btn btn-primary' href='{{route('cadastrar-tipo-documento-contabil')}}'><span class="fa fa-plus"></span> Cadastrar um tipo de documento contábil</a><br />
    <div class="clearfix"></div>
</div>
@stop