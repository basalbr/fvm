@extends('layouts.admin')
@section('header_title', 'Editar Natureza Jurídica')
@section('main')
<div class="card">
    <h1>Editar Natureza Jurídica</h1>
    @if($errors->has())
    <div class="alert alert-warning shake">
        <b>Atenção</b><br />
        @foreach ($errors->all() as $error)
        {{ $error }}<br />
        @endforeach
    </div>
    @endif
    <form method="POST" action="">
        <div class='col-xs-12'>
            {{ csrf_field() }}
            <div class='form-group'>
                <label>Código</label>
                <input type='text' class='form-control' name='codigo' value="{{$natureza_juridica->codigo}}"/>
            </div>
            <div class='form-group'>
                <label>Descrição</label>
                <input type='text' class='form-control' name='descricao' value="{{$natureza_juridica->descricao}}"/>
            </div>
            <div class='form-group'>
                <label>Representante</label>
                <input type='text' class='form-control' name='representante' value="{{$natureza_juridica->representante}}"/>
            </div>
            <div class='form-group'>
                <label>Qualificação</label>
                <input type='text' class='form-control' name='qualificacao' value="{{$natureza_juridica->qualificacao}}"/>
            </div>
            <div class='form-group'>
              <button type="submit" class='btn btn-success'><span class="fa fa-save"></span> Salvar Alterações</button>
                <a href="{{URL::previous()}}" class="btn btn-primary"><span class='fa fa-history'></span> Voltar</a>
            </div>
        </div>
        <div class='clearfix'></div>
    </form>
</div>
@stop