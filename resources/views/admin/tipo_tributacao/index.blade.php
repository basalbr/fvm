@extends('layouts.master')
@section('header_title', 'Home')
@section('content')
<section id='page-header' style="margin-top: 55px" class="page-header">
    <div class='container'>
        <h1>Tipo de Tributação</h1>
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
                @if($tipo_tributacao->count())
                @foreach($tipo_tributacao as $tipo)
                <tr>
                    <td>{{$tipo->descricao}}</td>
                    <td><a href="{{route('editar-tipo-tributacao', ['id' => $tipo->id])}}">Editar</a> | <a href="{{$tipo->id}}">Remover</a></td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="2">Nenhum registro cadastrado</td>
                </tr>
                @endif
            </tbody>
        </table>
        <a href='{{route('cadastrar-tipo-tributacao')}}'>Cadastrar um tipo de tributação</a><br />
    </div>
</section>
@stop