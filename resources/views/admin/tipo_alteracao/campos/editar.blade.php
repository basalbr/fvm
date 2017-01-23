@extends('layouts.admin')
@section('main')
<div class="card">
    <h1>Editar campo {{$campo->descricao}}</h1>

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
                    <option value="string" {{$campo->tipo == 'string' ? 'selected=""' : ''}}>Linha de texto</option>
                    <option value="file" {{$campo->tipo == 'file' ? 'selected=""' : ''}}>Anexo</option>
                    <option value="textarea" {{$campo->tipo == 'textarea' ? 'selected=""' : ''}}>Texto grande</option>
                </select>
            </div>
            <div class='form-group'>
                <label>Nome</label>
                <input type='text' class='form-control' name='nome' value="{{$campo->nome}}"/>
            </div>
            <div class='form-group'>
                <label>Descrição</label>
                <input type='text' class='form-control' name='descricao' value="{{$campo->descricao}}"/>
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