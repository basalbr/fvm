@extends('layouts.master')
@section('header_title', 'Home')
@section('content')
<section id='page-header' style="margin-top: 55px" class="page-header">
    <div class='container'>
        <h1>Natureza Jurídica</h1>
    </div>
</section>
<section>
    <div class="container">

        @if($errors->has())
        <div class="alert alert-warning shake">
            <b>Atenção</b><br />
            @foreach ($errors->all() as $error)
            {{ $error }}<br />
            @endforeach
        </div>
        @endif
        <form method="POST" action="">
            {{ csrf_field() }}
            <div class='form-group'>
                <label>Descrição</label>
                <input type='text' class='form-control' name='descricao' value="{{Input::old('descricao')}}"/>
            </div>
            <div class='form-group'>
                <label>Representante</label>
                <input type='text' class='form-control' name='representante' value="{{Input::old('representante')}}"/>
            </div>
            <div class='form-group'>
                <label>Qualificação</label>
                <input type='text' class='form-control' name='qualificacao' value="{{Input::old('qualificacao')}}"/>
            </div>
            <div class='form-group'>
                <input type='submit' value="Cadastrar" class='btn btn-primary' />
            </div>
        </form>
    </div>
</div>
</section>
@stop