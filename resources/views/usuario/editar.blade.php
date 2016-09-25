@extends('layouts.dashboard')
@section('main')
@section('header_title', 'Editar Sócio')
<h1>Meus Dados</h1>
<p>Após modificar os campos abaixo, clique em "salvar alterações" para atualizar suas informações.</p>
<hr class='dash-title' />

<div class='col-xs-12'>
    <div class='card'>
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
                <label>Senha (Deixe em branco caso não queira mudar)</label>
                <input type='password' class='form-control' name='senha' />
            </div>
            <div class='form-group'>
                <label>Confirmar senha</label>
                <input type='password' class='form-control' name='senha_confirmation' />
            </div>
            <div class='form-group'>
                <input type='submit' value="Salvar alterações" class='btn btn-primary' />
            </div>
            <div class="clearfix"></div>
        </form>
    </div>
</div>
@stop