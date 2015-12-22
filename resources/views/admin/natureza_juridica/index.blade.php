@extends('layouts.master')
@section('header_title', 'Home')
@section('content')
<section id='page-header' style="margin-top: 55px" class="page-header">
    <div class='container'>
        <h1>Sistema</h1>
    </div>
</section>
<section>
    <div class="container">
        <p>Você não possui nenhuma empresa cadastrada, você precisa possuir pelo menos uma empresa cadastrada para poder utilizar nosso sistema.<br />
            <a href='{{route('cadastrar-empresa')}}'>Clique aqui para cadastrar uma empresa agora mesmo!</a></p>
    </div>
</section>
@stop