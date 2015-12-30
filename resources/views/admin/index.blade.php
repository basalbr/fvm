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
        <a href='{{route('cadastrar-simples-nacional')}}'>Cadastrar uma tabela do simples nacional</a><br />
        <a href='{{route('cadastrar-tipo-tributacao')}}'>Cadastrar um tipo de tributação</a><br />
        <a href='{{route('cadastrar-natureza-juridica')}}'>Cadastrar uma natureza jurídica</a><br />
        <a href='{{route('cadastrar-cnae')}}'>Cadastrar um CNAE</a><br />
    </div>
</section>
@stop