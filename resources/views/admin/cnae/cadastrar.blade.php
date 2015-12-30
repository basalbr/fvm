@extends('layouts.master')
@section('header_title', 'Home')
@section('content')
<section id='page-header' style="margin-top: 55px" class="page-header">
    <div class='container'>
        <h1>CNAE</h1>
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
                <label>Código</label>
                <input type='text' class='form-control' name='codigo' value="{{Input::old('codigo')}}"/>
            </div>
            <div class='form-group'>
                <label>Tabela do Simples Nacional</label>
                <select class="form-control" name="id_tabela_simples_nacional">
                    <option value="">Selecione uma opção</option>
                    @if($tabelas->count())
                    @foreach($tabelas as $tabela)
                    <option value="{{$tabela->id}}" {{$tabela->id == Input::old('id_tabela_simples_nacional') ? 'selected' : ''}} >{{$tabela->descricao}}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            <div class='form-group'>
                <input type='submit' value="Cadastrar" class='btn btn-primary' />
            </div>
        </form>
    </div>
</div>
</section>
@stop