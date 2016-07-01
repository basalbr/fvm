@extends('layouts.master')
@section('header_title', 'Home')
@section('content')
<section id='page-header' style="margin-top: 55px" class="page-header">
    <div class='container'>
        <h1>Instruções de {{$imposto->nome}}</h1>
    </div>
</section>
<section>
    <div class="container">
        <table class='table'>
            <thead>
                <tr>
                    <th>Ordem</th>
                    <th>Resumo</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @if($imposto->instrucoes()->count())
                @foreach($imposto->instrucoes()->orderBy('ordem')->get() as $instrucao)
                <tr>
                    <td>{{$instrucao->ordem}}</td>
                    <td>{{str_limit($instrucao->descricao, 50)}}</td>
                    <td><a href="{{route('editar-instrucao', ['id_imposto' =>$imposto->id,'id_instrucao' => $instrucao->id])}}">Editar</a> | <a href="{{$instrucao->id}}">Remover</a></td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="3">Nenhum registro cadastrado</td>
                </tr>
                @endif
            </tbody>
        </table>
        <a href='{{route('cadastrar-instrucao',['id_imposto' =>$imposto->id])}}'>Cadastrar uma instrução</a><br />
    </div>
</section>
@stop