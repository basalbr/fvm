@extends('layouts.dashboard')
@section('header_title', 'Abertura de Empresas')
@section('js')
@section('main')

<div class="card">
    <h1>Processos de abertura de empresa</h1>
<p>Abaixo estão as solicitações de abertura de empresa feita por você.</p>
<p><b>É necessário efetuar o pagamento de R$ 59,00 referente ao processo para que possamos abrir a empresa para você.</b></p>
    <h3>Lista de processos de abertura de empresa</h3>
    <div class="table-responsive">
        <table class='table table-hover table-striped'>
            <thead>
                <tr>
                    <th>Nome Preferencial</th>
                    <th>Status do Processo</th>
                    <th>Status do Pagamento</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @if($empresas->count())
                @foreach($empresas as $empresa)
                <tr>
                    <td>{{$empresa->nome_empresarial1}}</td>
                    <td>{{$empresa->status}}</td>
                    <td>{{$empresa->pagamento ? $empresa->pagamento->status : 'Cancelado'}}</td>
                    <td>
                        @if($empresa->status != 'Cancelado')
                        <a class='btn btn-primary' href="{{route('editar-abertura-empresa', ['id' => $empresa->id])}}"><span class="fa fa-search"></span> Visualizar Processo</a>
                        @endif
                        {!!$empresa->botao_pagamento()!!}
                        @if($empresa->status != 'Concluído' && $empresa->status != 'Cancelado')
                        <a class='btn btn-danger remover-registro' href="{{route('deletar-abertura-empresa',[$empresa->id])}}"><span class="fa fa-remove"></span> Cancelar Processo</a>
                        @endif
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="4">Nenhum registro cadastrado</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
    <div class="clearfix"></div>
    <br />
    <a class='btn btn-success' href='{{route('cadastrar-abertura-empresa')}}'><span class="fa fa-child"></span> solicitar abertura de empresa</a>
</div>
@stop
