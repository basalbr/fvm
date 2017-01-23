@extends('layouts.admin')
@section('header_title', 'Chamados')
@section('main')
<div class="card">
    <h1>Tipos de Alteração</h1>

    
    <h3>Lista de Tipos de Alteração</h3>
    <div class="table-responsive">
        <table class='table table-striped table-hover'>
            <thead>
                <tr>
                    <th>Descrição</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @if($tipos_alteracao->count())
                @foreach($tipos_alteracao as $tipo_alteracao)
                <tr>
                    <td>{{$tipo_alteracao->descricao}}</td>
                    <td style="width: 200px;">
                        <a class="btn btn-info" href="{{route('listar-campo-alteracao', ['id' => $tipo_alteracao->id])}}"><span class="fa fa-list"></span> Campos</a>
                        <a class="btn btn-warning" href="{{route('editar-tipo-alteracao', ['id' => $tipo_alteracao->id])}}"><span class="fa fa-edit"></span> Editar</a>
                        <a class="btn btn-danger" href="{{$tipo_alteracao->id}}"><span class="fa fa-remove"></span> Remover</a>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="2">Nenhum registro cadastrado</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
    <div class="clearfix"></div>
    <a class='btn btn-primary' href='{{route('cadastrar-tipo-alteracao')}}'><span class="fa fa-plus"></span> Cadastrar um Tipo de Alteração</a><br />
    <div class="clearfix"></div>
</div>
@stop