@extends('layouts.master')
@section('header_title', 'Home')
@section('content')
<div class="container-fluid">
    <img id="parallax" src="{{url(public_path().'images/banner.jpg')}}"/>
        <div class="card" style="width: 600px; margin: 55px auto 0;  position: relative">
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
                    {{ csrf_field() }}
                    <div class='form-group'>
                        <label>E-mail</label>
                        <input type='text' class='form-control' name='email'  value="{{isset($email) && !empty($email) ? $email : Input::old('email')}}"/>
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
                <div class="clearfix"></div>
            </form>
        </div>
        </div>

@stop