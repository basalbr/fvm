@extends('layouts.master')
@section('header_title', 'Home')
@section('content')
<section id='page-header' style="margin-top: 55px" class="page-header">
    <div class='container'>
        <h1>Imposto</h1>
    </div>
</section>
<section>
    <div class="container">
        <table class='table'>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @if($impostos->count())
                @foreach($impostos as $imposto)
                <tr>
                    <td>{{$imposto->nome}}</td>
                    <td><a href="{{route('listar-instrucao', ['id' => $imposto->id])}}">Instruções</a> | <a href="{{route('editar-imposto', ['id' => $imposto->id])}}">Editar</a> | <a href="{{$imposto->id}}">Remover</a></td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="2">Nenhum registro cadastrado</td>
                </tr>
                @endif
            </tbody>
        </table>
        <a href='{{route('cadastrar-imposto')}}'>Cadastrar um imposto</a><br />
    </div>
</section>
@stop