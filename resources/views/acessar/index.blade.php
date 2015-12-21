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
</div>
</section>
@stop