@extends('layouts.admin')
@section('header_title', 'Editar Tipo de Documento Contábil')
@section('main')

<div class="card">
    <h1>Editar Tipo de Documento Contábil</h1>
    @if($errors->has())
    <div class="alert alert-warning shake">
        <b>Atenção</b><br />
        @foreach ($errors->all() as $error)
        {{ $error }}<br />
        @endforeach
    </div>
    @endif
    <h3>Informações</h3>
    <form method="POST" action="">
        <div class="col-xs-12">
            {{ csrf_field() }}
            <div class='form-group'>
                <label>Descrição</label>
                <input type='text' class='form-control' name='descricao' value="{{$tipo_documento_contabil->descricao}}"/>
            </div>
             <div class='form-group'>
                <button type="submit" class='btn btn-success'><span class="fa fa-plus"></span> Editar</button>
                <a href="{{URL::previous()}}" class="btn btn-primary"><span class='fa fa-history'></span> Voltar</a>
            </div>
        </div>
    </form>
    <div class="clearfix"></div>
</div>
@stop