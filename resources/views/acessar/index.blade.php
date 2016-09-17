@extends('layouts.master')
@section('header_title', 'Home')
@section('content')
<div class="container card" style="max-width: 600px; margin-top: 55px; padding: 0px 15px">
    <h1>Acesso ao sistema</h1>
    <p>Olá, digite seu e-mail e clique em continuar para acessar o sistema.</p>
    <form method="POST" action="">
        <div class='form-group'>
            <label>E-mail</label>
            <input type='text' class='form-control' name='email' />
        </div>
        <div class='form-group'>
            <input type='submit' value="Continuar" class='btn btn-primary' />
        </div>
    </form>
</div>


@stop