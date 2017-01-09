@extends('layouts.dashboard')
@section('header_title', $pro_labore->socio->nome .' - Competência: '. date_format(date_create($pro_labore->competencia.'T00:00:00'),'m/Y'))
@section('main')
<div class="card">
<h1>Visualizar Pró-Labore</h1>

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
            <div class="info">{{$pro_labore->socio->pessoa->nome_fantasia}}</div>
        </div>
        <div class="pull-left">
            <div class="titulo">Nome</div>
            <div class="info">{{$pro_labore->socio->nome}}</div>
        </div>
        <div class="pull-left">
            <div class="titulo">Pró-labore</div>
            <div class="info">{{$pro_labore->socio->pro_labore}}</div>
        </div>
        <div class="clearfix"></div>
        <div class="pull-left">
            <div class="titulo">CPF</div>
            <div class="info">{{$pro_labore->socio->cpf}}</div>
        </div>
        <div class="pull-left">
            <div class="titulo">Competência</div>
            <div class="info">{{date_format(date_create($pro_labore->competencia.'T00:00:00'),'m/Y')}}</div>
        </div>
        <div class="pull-left">
            <div class="titulo">Telefone</div>
            <div class="info">{{$pro_labore->socio->telefone}}</div>
        </div>
        <div class="clearfix"></div>
        <div class="pull-left">
            <div class="titulo">Pró-Labore</div>
            <div class="info"><a download href='{{asset('/uploads/pro_labore/'.$pro_labore->pro_labore)}}' target="_blank">Download</a></div>
        </div>
        <div class="pull-left">
            <div class="titulo">INSS</div>
            <div class="info"><a download href='{{asset('/uploads/inss/'.$pro_labore->inss)}}' target="_blank">Download</a></div>
        </div>
        @if($pro_labore->irrf)
        <div class="pull-left">
            <div class="titulo">IRRF</div>
            <div class="info"><a download href='{{asset('/uploads/irrf/'.$pro_labore->irrf)}}' target="_blank">Download</a></div>
        </div>
        @endif
        <div class="clearfix"></div>
    </blockquote>
</div>
<div class="col-xs-12">
<div class='form-group'>
    <a href='{{URL::previous()}}' class='btn btn-primary'>Voltar para listagem</a>
</div>
    </div>
<div class="clearfix"></div>
</div>
@stop