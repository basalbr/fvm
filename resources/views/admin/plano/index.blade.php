@extends('layouts.master')
@section('header_title', 'Home')
@section('content')
<section id='page-header' style="margin-top: 55px" class="page-header">
    <div class='container'>
        <h1>Planos de Pagamento</h1>
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
                @if($planos->count())
                @foreach($planos as $plano)
                <tr>
                    <td>{{$plano->descricao}}</td>
                    <td>{{$plano->representante}}</td>
                    <td>{{$plano->qualificacao}}</td>
                    <td><a href="{{route('editar-plano', ['id' => $plano->id])}}">Editar</a> | <a href="{{$plano->id}}">Remover</a></td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="2">Nenhum registro cadastrado</td>
                </tr>
                @endif
            </tbody>
        </table>
        <a href='{{route('cadastrar-plano')}}'>Cadastrar um plano de pagamento</a><br />
    </div>
</section>
@stop