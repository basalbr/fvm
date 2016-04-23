@extends('layouts.master')
@section('header_title', 'Home')
@section('content')
<section id='page-header' style="margin-top: 55px" class="page-header">
    <div class='container'>
        <h1>Empresas</h1>
    </div>
</section>
<section>
    <div class="container">
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
        <a href='{{route('cadastrar-cnae')}}'>Cadastrar um CNAE</a><br />
    </div>
</section>
@stop