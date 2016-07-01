@extends('layouts.dashboard')
@section('header_title', 'Chamados')
@section('main')
<h1>Chamado: {{$chamado->titulo}}</h1>
<hr class="dash-title">

@if($errors->has())
<div class="alert alert-warning shake">
    <b>Atenção</b><br />
    @foreach ($errors->all() as $error)
    {{ $error }}<br />
    @endforeach
</div>
@endif
<div class='form-group'>
    <label>Título</label>
    <input type='text' class='form-control' value="{{$chamado->titulo}}"/>
</div>
<div class='form-group'>
    <label>Mensagem Original</label>
    <textarea class="form-control" disabled="">{{$chamado->mensagem}}</textarea>
</div>
<form method="POST" action="">
    {{ csrf_field() }}
    <div class='form-group'>
        <label>Nova Resposta</label>
        <textarea class="form-control" name='mensagem'></textarea>
    </div>
    <div class='form-group'>
        <input type='submit' value="Enviar resposta" class='btn btn-primary' />
    </div>
</form>
<h3>Últimas repostas:</h3>
@foreach($chamado->chamado_respostas()->orderBy('updated_at', 'desc')->get() as $resposta)
<div class='form-group'>
    <label>{{$resposta->usuario->nome}} em {{date_format($resposta->updated_at, 'd/m/Y')}} às {{date_format($resposta->updated_at, 'H:i')}}</label>
    <textarea class="form-control" disabled="">{{$resposta->mensagem}}</textarea>
</div>
@endforeach

@stop