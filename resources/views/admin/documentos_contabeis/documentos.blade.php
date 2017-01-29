@extends('layouts.admin')

@section('header_title', 'Documentos Contábeis')
@section('main')

<div class="card">
    <h1>Lista de Documentos de {{$processo->periodo->format('m/Y')}}</h1>
    <div class="processo-info">
        <h3>Informações</h3>
        <blockquote>
            <div class="pull-left">
                <div class="titulo">Nome Fantasia</div>
                <div class="info"><a href="{{route('editar-empresa-admin', [$processo->pessoa->id])}}">{{$processo->pessoa->nome_fantasia}}</a></div>
            </div>
            <div class="pull-left">
                <div class="titulo">Razão Social</div>
                <div class="info">{{$processo->pessoa->razao_social}}</div>
            </div>
            <div class="pull-left">
                <div class="titulo">CNPJ</div>
                <div class="info">{{$processo->pessoa->cpf_cnpj}}</div>
            </div>
            <div class="clearfix"></div>
            <div class="pull-left">
                <div class="titulo">Status</div>
                <div class="info">{{$processo->status_formatado()}}</div>
            </div>
            <div class="pull-left">
                <div class="titulo">Período</div>
                <div class="info">{{$processo->periodo->format('m/Y')}}</div>
            </div>
            <div class="clearfix"></div>
        </blockquote>
    </div>

    <h3>Lista de documentos</h3>
    <div class="col-xs-12">

        <table class='table table-hover table-striped'>
            <thead>
                <tr>
                    <th>Descrição</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @if($documentos->count())
                @foreach($documentos as $documento)
                <tr>
                    <td>{{$documento->descricao}}</td>
                    <td><a class='btn btn-primary' href="{{asset('/uploads/documentos_contabeis/'.$documento->anexo)}}" target="_blank"><span class="fa fa-download"></span> Download</a></td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="2">Nenhum registro encontrado</td>
                </tr>
                @endif
            </tbody>
        </table>

        {!! str_replace('/?', '?', $documentos->render()) !!}
    </div>
    <div class="clearfix"></div>
    @if($processo->status != 'contabilizado' && $processo->status != 'sem_movimento')
    <br />
    <h3>opções</h3>
    <div class="col-xs-12">
        <div class="form-group">

            <a href="{{route('mudar-status-documento-contabil-admin',[$processo->id])}}" class="btn btn-success"><span class="fa fa-check"></span> Contabilizar</a>
        </div>
    </div>
    <div class="clearfix"></div>
    @endif
</div>

@stop