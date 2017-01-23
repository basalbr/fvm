@extends('layouts.dashboard')
@section('header_title', $alteracao->descricao)
@section('main')

<div class="card">
    <h1>{{$alteracao->descricao}}</h1>
    @if($errors->has())
    <div class="alert alert-warning shake">
        <b>Atenção</b><br />
        @foreach ($errors->all() as $error)
        {{ $error }}<br />
        @endforeach
    </div>
    @endif
    <h3>Informações</h3>
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="col-md-12">
            <p>Preencha os campos abaixo e cliquem em "Enviar Solicitação".</p>
            {{ csrf_field() }}
            @foreach($alteracao->campos as $campo)
            @if($campo->tipo == 'string')
            <div class='form-group'>
                <label>{{$campo->nome}}</label>
                <input type='text' class='form-control' value="{{Input::old($campo->id)}}" name='{{$campo->id}}' placeholder="{{$campo->descricao}}"/>
            </div>
            @elseif($campo->tipo == 'textarea')
            <div class='form-group'>
                <label>{{$campo->nome}}</label>
                <textarea name='{{$campo->id}}' class='form-control' placeholder="{{$campo->descricao}}"></textarea> 
            </div>
            @elseif($campo->tipo == 'file')
            <div class='form-group'>
                <label>{{$campo->nome}}</label>
                <input type='file' class='form-control' value="" name='anexo[{{$campo->id}}]'/>
            </div>
            @endif
            @endforeach

            <div class='form-group'>
                <button type='submit' class='btn btn-success'><span class='fa fa-send'></span> Enviar Solicitação</button>
                <a href="{{URL::previous()}}" class="btn btn-primary"><span class='fa fa-history'></span> Voltar</a>
            </div>
        </div>
    </form>
    <div class="clearfix"></div>
</div>
@stop