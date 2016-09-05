@extends('layouts.admin')
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
            <div class="titulo">Empresa</div>
            <div class="info">{{$processo->pessoa->nome_fantasia}}</div>
        </div>
        <div class="pull-left">
            <div class="titulo">CNPJ</div>
            <div class="info">{{$processo->pessoa->cpf_cnpj}}</div>
        </div>
        <div class="clearfix"></div>
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
        @if($processo->informacoes_extras()->count())
        <div class="clearfix"></div>
        @foreach($processo->informacoes_extras as $informacao_extra)
        <div class="pull-left">
            <div class="titulo">{{$informacao_extra->informacao_extra->nome}}</div>
            @if($informacao_extra->informacao_extra->tipo=='informacao_adicional')
            <div class="info">{{$informacao_extra->informacao}}</div>
            @endif
            @if($informacao_extra->informacao_extra->tipo=='anexo')
            <div class="info"><a download href='{{asset('/uploads/processos/'.$informacao_extra->informacao)}}' target="_blank">Download</a></div>
            @endif
        </div>
        @endforeach
        @endif
        @if($processo->guia)
        <div class="clearfix"></div>
        <div class="pull-left">
            <div class="titulo">Guia do Processo</div>
            <div class="info"><a download href='{{asset('/uploads/guias/'.$processo->guia)}}' target="_blank">Download</a></div>
        </div>
        @endif
        <div class="clearfix"></div>
    </blockquote>
</div>

<form method="POST" action="" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="form-group">
        <label>Anexar Arquivo</label>
        <input type="file" name="guia" class="form-control"/>
    </div>
    <div class='form-group'>
        <label>Mudar Status</label>
        <select name='status' class='form-control'>
            <option value="atencao" {{$processo->status == 'atencao' ? 'selected=""' : ''}}>Atenção</option>
            <option value="cancelado" {{$processo->status == 'cancelado' ? 'selected=""' : ''}}>Cancelado</option>
            <option value="concluido" {{$processo->status == 'concluido' ? 'selected=""' : ''}}>Concluído</option>
            <option value="pendente" {{$processo->status == 'pendente' ? 'selected=""' : ''}}>Pendente</option>
        </select>
    </div>
    <div class='form-group'>
        <label>Nova Mensagem</label>
        <textarea class="form-control" name='mensagem' required=""></textarea>
    </div>
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