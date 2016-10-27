@extends('layouts.dashboard')
@section('header_title', 'Chamados')
@section('main')
<h1>Abrir Chamado</h1>
<hr class="dash-title">
<div class="col-xs-12">
    <div class="card">
        <h3>Chamado</h3>
        <p>Complete os campos abaixo e clique em abrir chamado para abrir um novo chamado. Responderemos o mais breve possível.</p>
        @if($errors->has())
        <div class="alert alert-warning shake">
            <b>Atenção</b><br />
            @foreach ($errors->all() as $error)
            {{ $error }}<br />
            @endforeach
        </div>
        @endif
        <form method="POST" action="" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class='form-group'>
                <label>Anexar arquivo</label>
                <input type='file' class='form-control' value="" name='anexo'/>
            </div>
            <div class='form-group'>
                <label>Título</label>
                <input type='text' class='form-control' name='titulo' value=""/>
            </div>
            <div class='form-group'>
                <label>Mensagem</label>
                <textarea class="form-control" name='mensagem'></textarea>
            </div>
            <div class='form-group'>
                <input type='submit' value="Abrir chamado" class='btn btn-primary' />
            </div>
            <div class="clearfix"></div>
        </form>
    </div>
</div>
@stop