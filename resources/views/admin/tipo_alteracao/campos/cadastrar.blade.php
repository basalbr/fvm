@extends('layouts.admin')
@section('main')
<div class="card">
    <h1>Cadastrar Campo</h1>
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
        {{ csrf_field() }}
        <div class="col-xs-12">
            <div class='form-group'>
                <label>Tipo</label>
                <select name="tipo" class='form-control'>
                    <option value="string">Linha de texto</option>
                    <option value="file">Anexo</option>
                    <option value="textarea">Texto grande</option>
                </select>
            </div>
            <div class='form-group'>
                <label>Nome</label>
                <input type='text' class='form-control' name='nome' value="{{Input::old('nome')}}"/>
            </div>
            <div class='form-group'>
                <label>Descrição</label>
                <input type='text' class='form-control' name='descricao' value="{{Input::old('descricao')}}"/>
            </div>
            <div class='form-group'>
                <button type="submit" class='btn btn-success'><span class="fa fa-plus"></span> Cadastrar Campo</button>
                <a href="{{URL::previous()}}" class="btn btn-primary"><span class='fa fa-history'></span> Voltar</a>
            </div>
        </div>
        <div class='clearfix'></div>
    </form>
</div>
@stop