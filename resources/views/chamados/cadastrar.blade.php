@extends('layouts.dashboard')
@section('header_title', 'Chamados')
@section('main')


<div class="card">
    <h1>Abrir Chamado</h1>
    
    <h3>Chamado</h3>
    <div class='col-xs-12'>
    <p>Complete os campos abaixo e clique em abrir chamado para abrir um novo chamado. Responderemos o mais breve possível.</p>
    </div>
    @if($errors->has())
    <div class="alert alert-warning shake">
        <b>Atenção</b><br />
        @foreach ($errors->all() as $error)
        {{ $error }}<br />
        @endforeach
    </div>
    @endif
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="col-md-12">
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
            <button type='submit'class='btn btn-success'><span class='fa fa-envelope-open-o'></span>  Abrir Chamado</button>
                <a href="{{URL::previous()}}" class="btn btn-primary"><span class='fa fa-history'></span> Voltar</a>
        </div>
        </div>
        <div class="clearfix"></div>
    </form>
</div>
@stop