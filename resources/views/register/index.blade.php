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

        <div class="card">
            <h3>Cadastro de usuário</h3>
            <p>Olá, complete as informações abaixo para se cadastrar em nosso sistema. O cadastro é gratuito e não será cobrada nenhuma taxa por isso.</p>
            @if($errors->has())
            <div class="animated alert alert-warning shake">
                <b>Atenção</b><br />
                @foreach ($errors->all() as $error)
                {{ $error }}<br />
                @endforeach
            </div>
            @endif

            <form method="POST" action="">
                <div class="col-xs-12">
                    {{ csrf_field() }}
                    <div class='form-group'>
                        <label>E-mail</label>
                        <input type='text' class='form-control' name='email'  value="{{Input::old('email')}}"/>
                    </div>
                    <div class='form-group'>
                        <label>Nome</label>
                        <input type='text' class='form-control' name='nome'  value="{{Input::old('nome')}}"/>
                    </div>
                    <div class='form-group'>
                        <label>Telefone</label>
                        <input type='text' class='form-control fone-mask' name='telefone' value="{{Input::old('telefone')}}"/>
                    </div>
                    <div class='form-group'>
                        <label>Senha</label>
                        <input type='password' class='form-control' name='senha' />
                    </div>
                    <div class='form-group'>
                        <label>Confirmar senha</label>
                        <input type='password' class='form-control' name='senha_confirmation' />
                    </div>
                    <div class='form-group'>
                        <input type='submit' value="Cadastrar-se" class='btn btn-primary' />
                        <a href="{{route('home')}}" class='btn btn-warning'>Voltar para página inicial</a>
                    </div>
                </div>
                <div class="clearfix"></div>
            </form>
        </div>
    </div>
</section>
@stop