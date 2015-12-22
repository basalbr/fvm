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

        @if($errors->has())
        <div class="alert alert-warning shake">
            <b>Atenção</b><br />
            @foreach ($errors->all() as $error)
            {{ $error }}<br />
            @endforeach
        </div>
        @endif
        <p>Olá, digite seu e-mail e clique em continuar para acessar o sistema.</p>
        <form method="POST" action="">
            <input type="hidden" value="J" name='tipo' />
            <div class='form-group'>
                <label>Nome Fantasia</label>
                <input type='text' class='form-control' name='nome_fantasia' />
            </div>
            <div class='form-group'>
                <label>Razão Social</label>
                <input type='text' class='form-control' name='razao_social' />
            </div>
            <div class='form-group'>
                <label>CNPJ</label>
                <input type='text' class='form-control' name='cnpj' />
            </div>
            <div class='form-group'>
                <label>Inscricao Estadual</label>
                <input type='text' class='form-control' name='inscricao_estadual' />
            </div>
            <div class='form-group'>
                <label>Inscricao Municipal</label>
                <input type='text' class='form-control' name='inscricao_municipal' />
            </div>
            <div class='form-group'>
                <label>IPTU</label>
                <input type='text' class='form-control' name='iptu' />
            </div>
            <div class='form-group'>
                <label>Quantidade de funcionários</label>
                <input type='text' class='form-control' name='qtde_funcionarios' />
            </div>
            <div class='form-group'>
                <label>Natureza Jurídica</label>
                <input type='text' class='form-control' name='qtde_funcionarios' />
            </div>
            <div class='form-group'>
                <label>CEP</label>
                <input type='text' class='form-control' name='cep' />
            </div>
            <div class='form-group'>
                <label>Estado</label>
                <input type='text' class='form-control' name='estado' />
            </div>
            <div class='form-group'>
                <label>Cidade</label>
                <input type='text' class='form-control' name='cidade' />
            </div>
            <div class='form-group'>
                <label>Endereço</label>
                <input type='text' class='form-control' name='endereco' />
            </div>
            <div class='form-group'>
                <label>Numero</label>
                <input type='text' class='form-control' name='numero' />
            </div>
            <div class='form-group'>
                <label>Bairro</label>
                <input type='text' class='form-control' name='endereco' />
            </div>
            <div class='form-group'>
                <label>E-mail do responsável</label>
                <input type='text' class='form-control' name='email' />
            </div>
            <div class='form-group'>
                <label>Nome do responsável</label>
                <input type='text' class='form-control' name='responsavel' />
            </div>
            <div class='form-group'>
                <label>Telefone do responsável</label>
                <input type='text' class='form-control' name='telefone' />
            </div>
           
            <div class='form-group'>
                <input type='submit' value="Cadastrar" class='btn btn-primary' />
            </div>
        </form>
    </div>
</div>
</section>
@stop