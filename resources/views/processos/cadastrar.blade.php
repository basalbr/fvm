@extends('layouts.dashboard')
@section('header_title', 'Processos')
@section('main')
<h1>Abrir Processo de {{$imposto->nome}} - Competência {{$competencia}}</h1>
<hr class="dash-title">

@if($errors->has())
<div class="alert alert-warning shake">
    <b>Atenção</b><br />
    @foreach ($errors->all() as $error)
    {{ $error }}<br />
    @endforeach
</div>
@endif
<form method="POST" action="{{route('criar-processo')}}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class='form-group'>
        <label>Empresa</label>
        <div class='input-group col-md-12'>
            <input type='text' class='form-control' disabled="" value="{{$empresa->nome_fantasia}}"/>
        </div>
    </div>
    <div class='form-group'>
        <label>CNPJ</label>
        <div class='input-group col-md-12'>
            <input type='text' class='form-control cnpj-mask' disabled=""  value="{{$empresa->cpf_cnpj}}"/>
        </div>
    </div>
    <div class='form-group'>
        <label>Imposto</label>
        <div class='input-group col-md-12'>
            <input type='text' class='form-control' disabled=""  value="{{$imposto->nome}}"/>
        </div>
    </div>
    <div class='form-group'>
        <label>Competência</label>
        <div class='input-group col-md-12'>
            <input type='text' class='form-control' disabled=""  value="{{$competencia}}"/>
        </div>
    </div>
    <div class='form-group'>
        <label>Data de Vencimento</label>
        <div class='input-group col-md-12'>
            <input type='text' class='form-control' disabled="" value="{{$vencimento}}"/>
        </div>
    </div>
    @if($imposto->informacoes_extras->count())
    @foreach($imposto->informacoes_extras()->orderBy('tipo')->orderBy('nome')->get() as $informacao_extra)
    @if($informacao_extra->tipo == 'anexo')
    <div class='form-group'>
        <label>{{$informacao_extra->nome}}</label>
        
        @if($informacao_extra->descricao)
        <p><i>{{$informacao_extra->descricao}}</i></p>
        @endif
        <p>Tamanho máximo: {{$informacao_extra->tamanho_maximo}}KBs<br />Extensões válidas: @foreach($informacao_extra->extensoes as $extensao) {!!'<span class="label label-primary">'.$extensao->extensao.'</span>'!!} @endforeach</p>
        <div class='input-group col-md-12'>
            <input type='file' class='form-control' value="" name='anexo[{{$informacao_extra->id}}]'/>
        </div>
    </div>
    @endif
    @if($informacao_extra->tipo == 'informacao_adicional')
    <div class='form-group'>
        <label>{{$informacao_extra->nome}}</label>
        @if($informacao_extra->descricao)
        <p><i>{{$informacao_extra->descricao}}</i></p>
        @endif
        <div class='input-group col-md-12'>
            <input type='text' class='form-control'  name="informacao_adicional[{{$informacao_extra->id}}]"/>
        </div>
    </div>
    @endif
    @endforeach
    @endif
    <input type='hidden' name="id_imposto" value="{{$imposto->id}}" class='form-control'/>
    <input type='hidden' name="id_pessoa" value="{{$empresa->id}}" class='form-control'/>
    <input type='hidden' name="competencia" value="{{$competencia}}" class='form-control'/>
    <input type='hidden' name="vencimento" value="{{$vencimento}}" class='form-control'/>
    <div class='form-group'>
        <input type='submit' value="Abrir processo" class='btn btn-primary' />
    </div>
</form>
@stop