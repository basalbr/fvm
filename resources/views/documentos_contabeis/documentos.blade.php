@extends('layouts.dashboard')

@section('header_title', 'Documentos Contábeis')
@section('main')

<div class="card">
    <h1>Lista de Documentos de {{$processo->periodo->format('m/Y')}}</h1>
    <div class="processo-info">
        <h3>Informações</h3>
        <blockquote>
            <div class="pull-left">
                <div class="titulo">Nome Fantasia</div>
                <div class="info">{{$processo->pessoa->nome_fantasia}}</div>
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
    @if($documentos->count())
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

                @foreach($documentos as $documento)
                <tr>
                    <td>{{$documento->descricao}}</td>
                    <td><a class='btn btn-primary' href="{{asset('/uploads/documentos_contabeis/'.$documento->anexo)}}" target="_blank"><span class="fa fa-download"></span> Download</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {!! str_replace('/?', '?', $documentos->render()) !!}

    </div>
    <div class="clearfix"></div>
    @endif
    @if(!$documentos->count() && ($processo->status != 'sem_movimento' && $processo->status != 'contabilizado'))
    <br />
    <h3>opções</h3>
    <div class="col-xs-12">
        <p>Caso tenha havido movimentação de documentos, clique em <b>Enviar Documentos Contábeis</b>.<br />Caso contrário clique em <b>Não Houve Movimentação</b>.<br /> Se tiver dúvidas como proceder, <a href="{{route('cadastrar-chamado')}}"><b>abra um chamado</b></a> para que possamos ajudar.</p>
        <div class="form-group">

            <a href="{{route('enviar-documento-contabil',[$processo->id])}}" class="btn btn-primary"><span class="fa fa-upload"></span> Enviar Documentos Contábeis</a>
            <a href="{{route('sem-movimento-documento-contabil',[$processo->id])}}" class="btn btn-warning"><span class="fa fa-times-circle"></span> Não Houve Movimentação nesse período</a>
        </div>
    </div>
    <div class="clearfix"></div>
    @endif

</div>

@stop