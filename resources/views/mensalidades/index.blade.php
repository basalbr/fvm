@extends('layouts.dashboard')
@section('header_title', 'Mensalidades')
@section('main')

<div class="card">
    <h1>Mensalidades</h1>

    <p>Abaixo estão as mensalidades ativas em nosso sistema.</p>
        <h3>Lista de Mensalidades</h3>

    <div class='table-responsive'>
    <table class='table table-hover table-striped'>
        <thead>
            <tr>
                <th>Empresa</th>
                <th>Valor</th>
                <th>Limite de Documentos Fiscais</th>
                <th>Limite de Documentos Contábeis</th>
                <th>Limite de Pró-labores</th>
                <th>Limite de Funcionários</th>
                <th>Último Pagamento</th>
                <th>Vencimento do Próximo Pagamento</th>
            </tr>
        </thead>
        <tbody>
            @if($mensalidades->count())
            @foreach($mensalidades as $mensalidade)
            <tr>
                <td>{{$mensalidade->empresa->nome_fantasia}}</td>
                <td>R${{number_format($mensalidade->valor,2,',','.')}}</td>
                <td>Até {{$mensalidade->documentos_fiscais}}</td>
                <td>Até {{$mensalidade->documentos_contabeis}}</td>
                <td>Até {{$mensalidade->pro_labores}}</td>
                <td>Até {{$mensalidade->funcionarios}}</td>
                <td>{{$mensalidade->ultimo_pagamento('d/m/Y')}}</td>
                <td>{{$mensalidade->proximo_pagamento('d/m/Y')}}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="3">Nenhum mensalidade encontrada</td>
            </tr>
            @endif
        </tbody>
    </table>
        </div>
</div>

@stop