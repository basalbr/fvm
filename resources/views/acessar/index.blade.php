@extends('layouts.master')
@section('header_title', 'Home')
@section('content')
<img id="parallax" src="{{url(public_path().'images/banner.jpg')}}"/>
<div class="container-fluid">
<div class="card" style="width: 600px; margin: 55px auto 0;  position: relative">
    <h3>Acesso ao sistema</h3>
    <p>Olá, digite seu e-mail e clique em continuar para acessar o sistema.</p>
    <p>Caso você não seja cadastrado, não tem problema, basta digitar seu e-mail que redirecionaremos para o formulário de cadastro.</p>
    <form method="POST" action="">
        <div class='form-group'>
            <label>E-mail</label>
            <input type='text' class='form-control' name='email' />
        </div>
        <div class='form-group'>
            <input type='submit' value="Continuar" class='btn btn-primary' />
            <a href="{{route('home')}}" class='btn btn-warning'>Voltar para página inicial</a>
        </div>
    </form>
    <div class="clearfix"></div>
</div>
</div>

@stop