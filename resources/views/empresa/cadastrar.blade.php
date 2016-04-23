@extends('layouts.master')
@section('header_title', 'Home')
@section('content')
<section id='page-header' style="margin-top: 55px" class="page-header">
    <div class='container'>
        <h1>Cadastrar empresa</h1>
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
        <p>Preencha os campos abaixo e clique em "cadastrar" para registrar sua empresa em nosso sistema.</p>
        <form method="POST" action="">
            {{ csrf_field() }}
            <input type="hidden" value="J" name='tipo' />
            <div class='form-group'>
                <label>Nome Fantasia</label>
                <input type='text' class='form-control' name='nome_fantasia' value="{{Input::old('nome_fantasia')}}"/>
            </div>
            <div class='form-group'>
                <label>Razão Social</label>
                <input type='text' class='form-control' name='razao_social' value="{{Input::old('razao_social')}}" />
            </div>
            <div class='form-group'>
                <label>CNPJ</label>
                <input type='text' class='form-control cnpj-mask' name='cpf_cnpj' value="{{Input::old('cpf_cnpj')}}"/>
            </div>
            <div class='form-group'>
                <label>CEP</label>
                <input type='text' class='form-control cep-mask' name='cep' value="{{Input::old('cep')}}" />
            </div>
            <div class='form-group'>
                <label>Estado</label>
                <input type='text' class='form-control' name='estado' value="{{Input::old('estado')}}" />
            </div>
            <div class='form-group'>
                <label>Cidade</label>
                <input type='text' class='form-control' name='cidade'  value="{{Input::old('cidade')}}"/>
            </div>
            <div class='form-group'>
                <label>Inscrição Estadual</label>
                <input type='text' class='form-control' name='inscricao_estadual'  value="{{Input::old('inscricao_estadual')}}"/>
            </div>
            <div class='form-group'>
                <label>Inscrição Municipal</label>
                <input type='text' class='form-control' name='inscricao_municipal' value="{{Input::old('inscricao_municipal')}}" />
            </div>
            <div class='form-group'>
                <label>IPTU</label>
                <input type='text' class='form-control' name='iptu'  value="{{Input::old('iptu')}}"/>
            </div>
            <div class='form-group'>
                <label>Quantidade de funcionários</label>
                <input type='text' class='form-control' name='qtde_funcionarios'  value="{{Input::old('qtde_funcionarios')}}"/>
            </div>
            <div class='form-group'>
                <label>Endereço</label>
                <input type='text' class='form-control' name='endereco'  value="{{Input::old('endereco')}}"/>
            </div>
            <div class='form-group'>
                <label>Número</label>
                <input type='text' class='form-control numero-mask' name='numero' value="{{Input::old('numero')}}"/>
            </div>
            <div class='form-group'>
                <label>Bairro</label>
                <input type='text' class='form-control' name='bairro'  value="{{Input::old('bairro')}}"/>
            </div>
            <div class='form-group'>
                <label>E-mail do responsável</label>
                <input type='text' class='form-control' name='email'  value="{{Input::old('email')}}"/>
            </div>
            <div class='form-group'>
                <label>Nome do responsável</label>
                <input type='text' class='form-control' name='responsavel' value="{{Input::old('responsavel')}}" />
            </div>
            <div class='form-group'>
                <label>Telefone do responsável</label>
                <input type='text' class='form-control fone-mask' name='telefone' value="{{Input::old('telefone')}}" />
            </div>
            <div class='form-group'>
                <label>Natureza Jurídica</label>
                <select class="form-control" name="id_natureza_juridica">
                    <option value="">Selecione uma opção</option>
                    @foreach($naturezasJuridicas as $natureza_juridica)
                    <option value="{{$natureza_juridica->id}}">{{$natureza_juridica->descricao}}</option>
                    @endforeach
                </select>
            </div>
            <div class='form-group'>
                <label>CNAE</label>
                <input type='text' class='form-control cnae-search'/>
                <div class="cnae-search-box"><div class="title">Resultado da pesquisa</div><div class="result"></div></div>
            </div>
            <div class='form-group'>
                <label>Tipo de Tributação</label>
                <select class="form-control" name="tipo_tributacao">
                    <option value="">Selecione uma opção</option>
                    @foreach($tipoTributacoes as $tributacao)
                    <option value="{{$tributacao->id}}">{{$tributacao->descricao}}</option>
                    @endforeach
                </select>
            </div>
            <div class='form-group'>
                <input type='submit' value="Cadastrar" class='btn btn-primary' />
            </div>
        </form>
    </div>
</div>
</section>
@stop