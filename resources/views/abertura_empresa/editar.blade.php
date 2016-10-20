@extends('layouts.dashboard')
@section('header_title', 'Abertura de Empresa')
@section('main')
<h1>Processo de abertura de empresa</h1>
<hr class="dash-title">
<div class="col-xs-12">
    <div class="card">
        <div class="processo-info">
            <h3>Processo de Abertura de Empresa</h3>
            <blockquote>
                <div class="pull-left">
                    <div class="titulo">Status do Processo</div>
                    <div class='text-success info'>{{$empresa->status}}</div>
                </div>
                <div class="pull-left">
                    <div class="titulo">Status do Pagamento</div>
                    <div class='text-success info'>{{$empresa->status_pagamento}}</div>
                </div>
                <div class="pull-left">
                    <div class="titulo">Nome Preferencial</div>
                    <div class="info">{{$empresa->nome_empresarial1}}</div>
                </div>
                <div class="pull-left">
                    <div class="titulo">Nome do Sócio Principal</div>
                    <div class="info">{{$empresa->socios()->where('principal','=',1)->first()->nome}}</div>
                </div>
                <div class='clearfix'></div>
                <div class="pull-left">
                    <div class="titulo"></div>
                    <div class="info"><a href=''>Clique aqui para ver todas as informações</a></div>
                </div>
                <div class='clearfix'></div>
            </blockquote>

        </div>
        @if($errors->has())
        <div class="alert alert-warning shake">
            <b>Atenção</b><br />
            @foreach ($errors->all() as $error)
            {{ $error }}<br />
            @endforeach
        </div>
        @endif
        <form method="POST" action="">
            {{ csrf_field() }}
            <h3>Nova Mensagem</h3>
            <div class='form-group'>
                
                <textarea class="form-control" name='mensagem'></textarea>
            </div>
            <div class='form-group'>
                <input type='submit' value="Enviar mensagem" class='btn btn-primary' />
            </div>
        </form>
        <h3>Últimas mensagens:</h3>
        @if($empresa->mensagens->count())
        @foreach($empresa->mensagens()->orderBy('updated_at', 'desc')->get() as $resposta)
        <div class='form-group'>
            <label>{{$resposta->usuario->nome}} em {{date_format($resposta->updated_at, 'd/m/Y')}} às {{date_format($resposta->updated_at, 'H:i')}}</label>
            <textarea class="form-control" disabled="">{{$resposta->mensagem}}</textarea>
        </div>
        @endforeach
        @else
        <p>Nenhuma mensagem encontrada</p>
        @endif
        <div class="clearfix"></div>
    </div>
</div>
@stop