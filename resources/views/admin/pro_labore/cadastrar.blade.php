@extends('layouts.admin')
@section('header_title', $socio->nome .' - Competência: '. date('m/Y'))
@section('main')
<div class="card">
    <h1>Cadastrar Pró-Labore</h1>

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
                <div class="info">{{$socio->pessoa->nome_fantasia}}</div>
            </div>
            <div class="pull-left">
                <div class="titulo">Nome</div>
                <div class="info">{{$socio->nome}}</div>
            </div>
            <div class="pull-left">
                <div class="titulo">Pró-labore</div>
                <div class="info">{{$socio->pro_labore}}</div>
            </div>
            <div class="clearfix"></div>
            <div class="pull-left">
                <div class="titulo">CPF</div>
                <div class="info">{{$socio->cpf}}</div>
            </div>
            <div class="pull-left">
                <div class="titulo">Competência</div>
                <div class="info">{{date('m/Y')}}</div>
            </div>
            <div class="pull-left">
                <div class="titulo">Telefone</div>
                <div class="info">{{$socio->telefone}}</div>
            </div>
            <div class="clearfix"></div>
        </blockquote>
    </div>

    <form method="POST" action="" enctype="multipart/form-data">
        <h3>Documentos</h3>
        {{ csrf_field() }}
        <div class="col-xs-12">
        <input type='hidden' name='valor_pro_labore' value="{{$socio->pro_labore}}" />
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
            <input type='submit' value="Enviar Arquivos" class='btn btn-primary' />
        </div>
        </div>
        <div class="clearfix"></div>
    </form>
</div>
@stop