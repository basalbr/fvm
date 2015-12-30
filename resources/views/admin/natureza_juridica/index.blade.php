@extends('layouts.master')
@section('header_title', 'Home')
@section('content')
<section id='page-header' style="margin-top: 55px" class="page-header">
    <div class='container'>
        <h1>Natureza Jurídica</h1>
    </div>
</section>
<section>
    <div class="container">
        <table class='table'>
            <thead>
                <tr>
                    <th>Descrição</th>
                    <th>Representante</th>
                    <th>Qualificação</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @if($naturezas_juridicas->count())
                @foreach($naturezas_juridicas as $natureza_juridica)
                <tr>
                    <td>{{$natureza_juridica->descricao}}</td>
                    <td>{{$natureza_juridica->representante}}</td>
                    <td>{{$natureza_juridica->qualificacao}}</td>
                    <td><a href="{{route('editar-natureza-juridica', ['id' => $natureza_juridica->id])}}">Editar</a> | <a href="{{$natureza_juridica->id}}">Remover</a></td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="2">Nenhum registro cadastrado</td>
                </tr>
                @endif
            </tbody>
        </table>
        <a href='{{route('cadastrar-natureza-juridica')}}'>Cadastrar uma natureza jurídica</a><br />
    </div>
</section>
@stop