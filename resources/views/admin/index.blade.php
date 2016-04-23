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
        <h2>Chamados</h2>
        <a href='{{route('listar-chamados')}}'>Listar os Chamados</a><br />
        <h2>CNAE</h2>
        <a href='{{route('cadastrar-cnae')}}'>Cadastrar um CNAE</a><br />
        <a href='{{route('listar-cnae')}}'>Listar os CNAEs</a><br />
        <h2>Natureza Jurídica</h2>
        <a href='{{route('cadastrar-natureza-juridica')}}'>Cadastrar uma natureza jurídica</a><br />
        <a href='{{route('listar-natureza-juridica')}}'>Listar as naturezas jurídicas</a><br />
        <h2>Tabela do Simples Nacional</h2>
        <a href='{{route('cadastrar-simples-nacional')}}'>Cadastrar uma tabela do simples nacional</a><br />
        <a href='{{route('listar-simples-nacional')}}'>Listar as tabelas do simples nacional</a><br />
        <h2>Tipo de Tributação</h2>
        <a href='{{route('cadastrar-tipo-tributacao')}}'>Cadastrar um tipo de tributação</a><br />
        <a href='{{route('listar-tipo-tributacao')}}'>Listar os tipos de tributação</a><br />
        
    </div>
</section>
@stop