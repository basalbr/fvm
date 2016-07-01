@extends('layouts.master')
@section('header_title', 'Home')
@section('content')
<section id='page-header' style="margin-top: 55px" class="page-header">
    <div class='container'>
        <h1>Acesso ao sistema</h1>
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
        <p>Olá <b>{{isset($nome) ? $nome : Input::old('nome')}}</b>, digite sua senha e clique em acessar.</p>
        <form method="POST" action="">
            <input type='hidden' class='form-control' name='nome' value="{{isset($nome) && !empty($email) ? $nome : Input::old('nome')}}" />
            <input type='hidden' class='form-control' name='email' value="{{isset($email) && !empty($email) ? $email : Input::old('email')}}" />
            <div class='form-group'>
                <label>Senha</label>
                <input type='password' class='form-control' name='password' />
            </div>
            <div class='form-group'>
                <input type='submit' value="Acessar" class='btn btn-primary' />
            </div>
        </form>
    </div>
</div>
</section>
@stop