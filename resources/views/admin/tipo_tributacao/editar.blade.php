@extends('layouts.master')
@section('header_title', 'Home')
@section('content')
<section id='page-header' style="margin-top: 55px" class="page-header">
    <div class='container'>
        <h1>Tipo de Tributação</h1>
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
                <input type='text' class='form-control' name='descricao' value="{{$tabela->descricao}}"/>
            </div>
                       <div class='form-group'>
                <label>Precisa de Tabela do Simples Nacional?</label>
                <select name='has_tabela' class='form-control'>
                    <option value="1" {{$tabela->has_tabela == true ? 'selected' : ''}}>Sim</option>
                    <option value="0"{{$tabela->has_tabela == false ? 'selected' : ''}}>Não</option>
                </select>
            </div>
            <div class='form-group'>
                <input type='submit' value="Salvar alterações" class='btn btn-primary' />
            </div>
        </form>
    </div>
</div>
</section>
@stop