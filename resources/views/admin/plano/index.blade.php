@extends('layouts.admin')
@section('header_title', 'Chamados')
@section('main')

<div class="card">
    <h1>Planos</h1>
  
    <h3>Lista de Planos de Pagamentos</h3>
    <table class='table'>
        <thead>
            <tr>
                <th>Doc. Fiscais</th>
                <th>Doc. Contábeis</th>
                <th>Funcionários</th>
                <th>Pró-labores</th>
                <th>Valor</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if($planos->count())
            @foreach($planos as $plano)
            <tr>
                <td>{{$plano->total_documentos}}</td>
                <td>{{$plano->total_documentos_contabeis}}</td>
                <td>{{$plano->funcionarios}}</td>
                <td>{{$plano->pro_labores}}</td>
                <td>R$ {{number_format($plano->valor, 2, ',','.')}}</td>
                <td><a class="btn btn-warning" href="{{route('editar-plano', ['id' => $plano->id])}}"><span class='fa fa-edit'></span> Editar</a> <a class="btn btn-danger" href="{{$plano->id}}"><span class='fa fa-remove'></span> Remover</a></td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="2">Nenhum registro cadastrado</td>
            </tr>
            @endif
        </tbody>
    </table>

    {!! str_replace('/?', '?', $planos->render()) !!}
    <div class="clearfix"></div>
    <a class='btn btn-primary' href='{{route('cadastrar-plano')}}'><span class='fa fa-plus'></span> Cadastrar</a><br />
    <div class="clearfix"></div>
</div>
@stop