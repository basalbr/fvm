@extends('layouts.dashboard')
@section('header_title', 'Mensalidades')
@section('main')
<h1>Mensalidades</h1>
<p>Abaixo estão as mensalidades ativas em nosso sistema.</p>
<hr class="dash-title">
<div class="card">
    <h3>Lista de Mensalidades</h3>
    <table class='table'>
        <thead>
            <tr>
                <th>Empresa</th>
                <th>Valor</th>
                <th>Limite de Documentos Fiscais</th>
                <th>Limite de Documentos Contábeis</th>
                <th>Limite de Pró-labores</th>
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
                <td>{{date_format($mensalidade->pagamentos()->where('status','=','Paga')->orderBy('created_at', 'desc')->first()->updated_at, 'd/m/Y')}}</td>
                <td>{{$mensalidade->proximo_pagamento()}}</td>
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

@stop