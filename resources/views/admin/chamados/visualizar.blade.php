@extends('layouts.admin')
@section('main')

<h1>Chamados</h1>
<hr class="dash-title">


@if($errors->has())
<div class="alert alert-warning shake">
    <b>Atenção</b><br />
    @foreach ($errors->all() as $error)
    {{ $error }}<br />
    @endforeach
</div>
@endif
<div class="col-xs-12">
    <div class='form-group'>
        <label>Título</label>
        <input type='text' class='form-control' value="{{$chamado->titulo}}"/>
    </div>
    <div class='form-group'>
        <label>Mensagem</label>
        <textarea class="form-control" disabled="">{{$chamado->mensagem}}</textarea>
    </div>
    @foreach($chamado->chamado_respostas()->orderBy('updated_at', 'asc')->get() as $resposta)
    <div class='form-group'>
        <label>{{$resposta->usuario()->get()->nome}}</label>
        <textarea class="form-control" disabled="">{{$resposta->mensagem}}</textarea>
    </div>
    @endforeach
</div>
<form method="POST" action="">
    {{ csrf_field() }}
    <div class='form-group'>
        <label>Resposta</label>
        <textarea class="form-control" name='resposta'></textarea>
    </div>
    <div class='form-group'>
        <input type='submit' value="Salvar alterações" class='btn btn-primary' />
    </div>
</form>
</div>

@stop