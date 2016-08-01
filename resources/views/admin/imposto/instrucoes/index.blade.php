@extends('layouts.admin')
@section('main')
<h1>Instruções de {{$imposto->nome}}</h1>
<hr class="dash-title">

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
                <td><a class="btn btn-warning" href="{{route('editar-instrucao', ['id_imposto' =>$imposto->id,'id_instrucao' => $instrucao->id])}}">Editar</a> <a class="btn btn-danger" href="{{$instrucao->id}}">Remover</a></td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="3">Nenhum registro cadastrado</td>
            </tr>
            @endif
        </tbody>
    </table>
    <a class='btn btn-primary' href='{{route('cadastrar-instrucao',['id_imposto' =>$imposto->id])}}'>Cadastrar uma instrução</a><br />

    @stop