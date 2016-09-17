@extends('layouts.dashboard')
@section('header_title', 'Empresas')

@section('main')
<h1>Empresas</h1>
<p>Abaixo estão as empresas cadastradas por você, caso queira editar ou visualizar alguma informação, clique em editar.<br/>Se você deseja gerenciar os sócios de uma empresa, clique em sócios.</p>
<hr class="dash-title">
<div class="card">
    <h3>Lista de empresas</h3>
    <table class='table'>
        <thead>
            <tr>
                <th>Nome Fantasia</th>
                <th>Razão Social</th>
                <th>CNPJ</th>
                <th>Nº de Sócios</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if($empresas->count())
            @foreach($empresas as $empresa)
            <tr>
                <td>{{$empresa->nome_fantasia}}</td>
                <td>{{$empresa->razao_social}}</td>
                <td>{{$empresa->cpf_cnpj}}</td>
                <td>{{$empresa->socios()->count()}}</td>
                <td><a class='btn btn-warning' href="{{route('editar-cnae', ['id' => $empresa->id])}}">Editar</a> <a class='btn btn-primary' href="{{route('listar-socios', [$empresa->id])}}">Sócios</a> <a class='btn btn-danger' href="{{$empresa->id}}">Remover</a></td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="2">Nenhum registro cadastrado</td>
            </tr>
            @endif
        </tbody>
    </table>
    <a class='btn btn-primary' href='{{route('cadastrar-empresa')}}'>Cadastrar uma empresa</a><br />
</div>
@stop