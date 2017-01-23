@extends('layouts.admin')
@section('header_title', 'Tipo de Alteração')

@section('main')

<div class="card">
    <h1>Tipo de Alteração</h1>
    @if($errors->has())
    <div class="alert alert-warning shake">
        <b>Atenção</b><br />
        @foreach ($errors->all() as $error)
        {{ $error }}<br />
        @endforeach
    </div>
    @endif
    <form method="POST" action="">
        <h3>Informações</h3>
        <div class="col-xs-12">
            {{ csrf_field() }}
            <div class='form-group'>
                <label>Descrição</label>
                <input type='text' class='form-control' name='descricao' value="{{Input::old('descricao')}}"/>
            </div>
            <div class='form-group'>
                <label>Valor</label>
                <input type='text' class='form-control dinheiro-mask' name='valor' value="{{Input::old('valor')}}"/>
            </div>
            <div class='form-group'>
                <button type="submit" class='btn btn-success'><span class="fa fa-plus"></span> Cadastrar Tipo de Alteração</button>
                <a href="{{URL::previous()}}" class="btn btn-primary"><span class='fa fa-history'></span> Voltar</a>
            </div>
        </div>
    </form>
    <div class="clearfix"></div>
</div>
@stop