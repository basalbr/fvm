@extends('layouts.dashboard')
@section('main')
@section('header_title', 'Editar Sócio')



    <div class='card'>
            <h1>dados de {{$usuario->nome}}</h1>

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
            <div class="col-xs-12">
            {{ csrf_field() }}
            <div class='form-group'>
                <label>E-mail</label>
                <input type='text' class='form-control' name='email'  value="{{$usuario->email}}"/>
            </div>
            <div class='form-group'>
                <label>Nome</label>
                <input type='text' class='form-control' name='nome'  value="{{$usuario->nome}}"/>
            </div>
            <div class='form-group'>
                <label>Telefone</label>
                <input type='text' class='form-control fone-mask' name='telefone' value="{{$usuario->telefone}}"/>
            </div>
            <div class='form-group'>
            <a href="{{URL::previous()}}" class="btn btn-primary"><span class='fa fa-history'></span> Voltar</a>
            </div>
            </div>
            <div class="clearfix"></div>
        </form>
    </div>
@stop