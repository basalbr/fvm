@extends('layouts.dashboard')
@section('header_title', $processo->imposto->nome .' - Competência: '. date_format(date_create($processo->competencia), 'm/Y'))
@section('main')
<h1>Visualizar Processo <small>{{$processo->imposto->nome}} - {{date_format(date_create($processo->competencia), 'm/Y')}}</small></h1>
<hr class="dash-title">

@if($errors->has())
<div class="alert alert-warning shake">
    <b>Atenção</b><br />
    @foreach ($errors->all() as $error)
    {{ $error }}<br />
    @endforeach
</div>
@endif
<div class="processo-info">
    <blockquote>
        <div class="pull-left">
            <div class="titulo">Status do Processo</div>
            @if($processo->status == 'pendente')
            <div class='text-info info'>Pendente</div>
            @elseif($processo->status == 'atencao')
            <div class='text-danger info'>Atenção</div>
            @elseif($processo->status == 'cancelado')
            <div class='text-muted info'>Cancelado</div>
            @elseif($processo->status == 'concluido')
            <div class='text-success info'>Concluído</div>
            @endif
        </div>
        <div class="pull-left">
            <div class="titulo">Empresa</div>
            <div class="info">{{$processo->pessoa->nome_fantasia}}</div>
        </div>
        <div class="pull-left">
            <div class="titulo">CNPJ</div>
            <div class="info">{{$processo->pessoa->cpf_cnpj}}</div>
        </div>
        <div class="pull-left">
            <div class="titulo">Imposto</div>
            <div class="info">{{$processo->imposto->nome}}</div>
        </div>
        <div class="pull-left">
            <div class="titulo">Competência</div>
            <div class="info">{{date_format(date_create($processo->competencia), 'm/Y')}}</div>
        </div>
        <div class="pull-left">
            <div class="titulo">Data de Vencimento</div>
            <div class="info">{{date_format(date_create($processo->vencimento), 'd/m/Y')}}</div>
        </div>
        @if($processo->guia)
        <div class="pull-left">
            <div class="titulo">Guia do Processo</div>
            <div class="info"><a download href='{{asset('/uploads/guias/'.$processo->guia)}}' target="_blank">Download</a></div>
        </div>
        @endif
        <div class="clearfix"></div>
    </blockquote>
</div>

<form method="POST" action="">
    {{ csrf_field() }}
    <div class='form-group'>
        <label>Nova Mensagem</label>
        <textarea class="form-control" name='mensagem' required=""></textarea>
    </div>
    @if($processo->status == 'atencao')
    <div class='form-group'>
        <label>Anexar arquivo</label>
        <input type='file' class='form-control' value="" name='anexo'/>
    </div>
    @endif
    <div class='form-group'>
        <input type='submit' value="Enviar mensagem" class='btn btn-primary' />
    </div>
</form>
@if($processo->processo_respostas->count())
<hr>
<h4>Últimas mensagens:</h4>
@foreach($processo->processo_respostas()->orderBy('updated_at', 'desc')->get() as $resposta)
<div class='form-group'>

    <div class="mensagem {{$resposta->usuario->id == Auth::user()->id ? 'mensagem-usuario':'mensagem-admin'}}">
        <p class='title'>{{$resposta->usuario->nome}} em {{date_format($resposta->updated_at, 'd/m/Y')}} às {{date_format($resposta->updated_at, 'H:i')}}</p>
        {{$resposta->mensagem}}
    </div>
</div>
@endforeach
@endif
@stop