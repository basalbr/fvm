@extends('layouts.dashboard')
@section('header_title', 'Funcionários')
@section('main')

<div class="card">
    <h1>Funcionários</h1>
    <h3>Lista de funcionários de {{\App\Pessoa::find($empresa)->nome_fantasia}}</h3>
    <table class='table'>
        <thead>
            <tr>
                <th>Nome Completo</th>
                <th>CPF</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if($funcionarios->count())
            @foreach($funcionarios as $funcionario)
            <tr>
                <td>{{$funcionario->nome_completo}}</td>
                <td>{{$funcionario->cpf}}</td>
                <td>
                    <a class='btn btn-warning' href="{{route('editar-funcionario', [$empresa, $funcionario->id])}}"><span class='fa fa-edit'></span> Editar Funcionário</a>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="3">Nenhum registro cadastrado</td>
            </tr>
            @endif
        </tbody>
    </table>
    @if($empresa->canRegisterFuncionario())
        <a class='btn btn-success' href="{{route('cadastrar-funcionario', [$empresa])}}"><span class='fa fa-user-plus'></span> Cadastrar Funcionário</a>
    @endif
    <a href="{{URL::previous()}}" class="btn btn-primary"><span class='fa fa-history'></span> Voltar</a>
</div>
@stop
