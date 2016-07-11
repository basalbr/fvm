@extends('layouts.admin')
@section('main')
<h1>Sistema</h1>
<hr class="dash-title">
<h2>Chamados</h2>
<a href='{{route('listar-chamados')}}'>Listar os Chamados</a><br />
<h2>CNAE</h2>
<a href='{{route('cadastrar-cnae')}}'>Cadastrar um CNAE</a><br />
<a href='{{route('listar-cnae')}}'>Listar os CNAEs</a><br />
<h2>Impostos</h2>
<a href='{{route('cadastrar-imposto')}}'>Cadastrar um imposto</a><br />
<a href='{{route('listar-imposto')}}'>Listar os impostos</a><br />
<h2>Natureza Jurídica</h2>
<a href='{{route('cadastrar-natureza-juridica')}}'>Cadastrar uma natureza jurídica</a><br />
<a href='{{route('listar-natureza-juridica')}}'>Listar as naturezas jurídicas</a><br />
<h2>Tabela do Simples Nacional</h2>
<a href='{{route('cadastrar-simples-nacional')}}'>Cadastrar uma tabela do simples nacional</a><br />
<a href='{{route('listar-simples-nacional')}}'>Listar as tabelas do simples nacional</a><br />
<h2>Tipo de Tributação</h2>
<a href='{{route('cadastrar-tipo-tributacao')}}'>Cadastrar um tipo de tributação</a><br />
<a href='{{route('listar-tipo-tributacao')}}'>Listar os tipos de tributação</a><br />

@stop
@section('header_title', 'Home')
