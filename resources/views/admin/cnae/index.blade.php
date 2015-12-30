@extends('layouts.master')
@section('header_title', 'Home')
@section('content')
<section id='page-header' style="margin-top: 55px" class="page-header">
    <div class='container'>
        <h1>CNAE</h1>
    </div>
</section>
<section>
    <div class="container">
        <table class='table'>
            <thead>
                <tr>
                    <th>Descrição</th>
                    <th>Código</th>
                    <th>Tabela do simples nacional</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @if($cnaes->count())
                @foreach($cnaes as $cnae)
                <tr>
                    <td>{{$cnae->descricao}}</td>
                    <td>{{$cnae->codigo}}</td>
                    <td>{{$cnae->id_tabela_simples_nacional}}</td>
                    <td><a href="{{route('editar-cnae', ['id' => $cnae->id])}}">Editar</a> | <a href="{{$cnae->id}}">Remover</a></td>
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