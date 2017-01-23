@extends('layouts.admin')
@section('header_title', 'Chamados')
@section('main')
<div class="card">
    <h1>Campos</h1>
    <h3>Lista de Campos</h3>
    <div class="table-responsive">
        <table class='table table-striped table-hover'>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @if($campos->count())
                @foreach($campos as $campo)
                <tr>
                    <td>{{$campo->nome}}</td>
                    <td style="width: 200px;"><a class="btn btn-warning" href="{{route('editar-campo-alteracao', [$id_alteracao, $campo->id])}}"><span class="fa fa-edit"></span> Editar</a> <a class="btn btn-danger" href="{{$campo->id}}"><span class="fa fa-remove"></span> Remover</a></td>
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
    <a class='btn btn-primary' href='{{route('cadastrar-campo-alteracao',[$id_alteracao])}}'><span class="fa fa-plus"></span> Cadastrar um campo</a><br />
    <div class="clearfix"></div>
</div>
@stop