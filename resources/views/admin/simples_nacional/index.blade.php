@extends('layouts.master')
@section('header_title', 'Home')
@section('content')
<section id='page-header' style="margin-top: 55px" class="page-header">
    <div class='container'>
        <h1>Tabela do Simples Nacional</h1>
    </div>
</section>
<section>
    <div class="container">
        <table class='table'>
            <thead>
                <tr>
                    <th>Descrição</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @if($tabelas->count())
                @foreach($tabelas as $tabela)
                <tr>
                    <td>{{$tabela->descricao}}</td>
                    <td><a href="{{route('editar-simples-nacional', ['id' => $tabela->id])}}">Editar</a> | <a href="{{$tabela->id}}">Remover</a></td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="2">Nenhum registro cadastrado</td>
                </tr>
                @endif
            </tbody>
        </table>
        <a href='{{route('cadastrar-simples-nacional')}}'>Cadastrar uma tabela do simples nacional</a><br />
    </div>
</section>
@stop