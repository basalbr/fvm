@extends('layouts.admin')
@section('header_title', 'Home')
@section('main')

<div class="card">
    <h1>CNAE</h1>
    @if($errors->has())
    <div class="alert alert-warning shake">
        <b>Atenção</b><br />
        @foreach ($errors->all() as $error)
        {{ $error }}<br />
        @endforeach
    </div>
    @endif
    <h3>Informações</h3>
    <div class="col-xs-12">
        <form method="POST" action="">
            {{ csrf_field() }}
            <div class='form-group'>
                <label>Descrição</label>
                <input type='text' class='form-control' name='descricao' value="{{$cnae->descricao}}"/>
            </div>
            <div class='form-group'>
                <label>Código</label>
                <input type='text' class='form-control cnae-mask' name='codigo' value="{{$cnae->codigo}}"/>
            </div>
            <div class='form-group'>
                <label>Tabela do Simples Nacional</label>
                <select class="form-control" name="id_tabela_simples_nacional">
                    <option value="">Selecione uma opção</option>
                    @if($tabelas->count())
                    @foreach($tabelas as $tabela)
                    <option value="{{$tabela->id}}" {{$tabela->id == $cnae->id_tabela_simples_nacional ? 'selected' : ''}}>{{$tabela->descricao}}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            <div class='form-group'>
                <button type="submit" class='btn btn-success'><span class="fa fa-save"></span> Salvar Alterações</button>
                <a href="{{URL::previous()}}" class="btn btn-primary"><span class='fa fa-history'></span> Voltar</a>
            </div>
        </form>
    </div>
    <div class="clearfix"></div>
</div>
@stop