@extends('layouts.dashboard')
@section('header_title', 'Funcionários')
@section('main')
<h1>Funcionários</h1>
<hr class="dash-title">
<div class="card">
    <h3>Lista de empresas</h3>
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
                    <a class='btn btn-info' href="{{route('editar-funcionario', [$empresa, $funcionario->id])}}">Editar Funcionário</a>
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
    <a class='btn btn-info' href="{{route('cadastrar-funcionario', [$empresa])}}">Cadastrar Funcionário</a>
</div>
@stop
