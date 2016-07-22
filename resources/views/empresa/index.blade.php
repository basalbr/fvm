@extends('layouts.dashboard')
@section('header_title', 'Empresas')
@section('main')
<h1>Empresas</h1>
<hr class="dash-title">
        <table class='table'>
            <thead>
                <tr>
                    <th>Nome Fantasia</th>
                    <th>CPF/CNPJ</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @if($empresas->count())
                @foreach($empresas as $empresa)
                <tr>
                    <td>{{$empresa->nome_fantasia}}</td>
                    <td>{{$empresa->cpf_cnpj}}</td>
                    <td><a href="{{route('editar-cnae', ['id' => $empresa->id])}}">Editar</a> | <a href="{{$empresa->id}}">Remover</a></td>
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
@stop