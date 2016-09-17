@extends('layouts.admin')
@section('header_title', $pro_labore->socio->nome .' - Competência: '. date_format(date_create($pro_labore->competencia.'T00:00:00'),'m/Y'))
@section('main')
<h1>Editar Pró-Labore <small>{{$pro_labore->socio->pessoa->nome_fantasia}} - {{$pro_labore->socio->nome}} - {{date_format(date_create($pro_labore->competencia.'T00:00:00'),'m/Y')}}</small></h1>
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

<form method="POST" action="" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type='hidden' name='valor_pro_labore' value="{{$pro_labore->valor_pro_labore}}" />
    <div class="form-group">
        <label>Anexar Pró-Labore</label>
        <input type="file" name="pro_labore" class="form-control"/>
    </div>
    <div class="form-group">
        <label>Anexar INSS</label>
        <input type="file" name="inss" class="form-control"/>
    </div>
    <div class="form-group">
        <label>IRRF</label>
        <input type="file" name="irrf" class="form-control"/>
    </div>
    <div class='form-group'>
        <input type='submit' value="Substituir Arquivos" class='btn btn-primary' />
    </div>
</form>
@stop