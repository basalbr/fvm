@extends('layouts.dashboard')
@section('main')
@section('header_title', 'Cadastrar Sócio')

<h1>Cadastro de Sócios</h1>


@if($errors->has())
<div class="alert alert-warning shake">
    <b>Atenção</b><br />
    @foreach ($errors->all() as $error)
    {{ $error }}<br />
    @endforeach
</div>
@endif
<form method="POST" action="">
    {{ csrf_field() }}
    <div class='form-group'>
        <label>Nome Completo</label>
        <input type='text' class='form-control' name='nome' value="{{Input::old('nome')}}" />
    </div> 

    <div class='form-group'>
        <label>Telefone Principal</label>
        <input type='text' class='form-control fone-mask' name='telefone' value="{{Input::old('telefone')}}" />
    </div>

    <div class='form-group'>
        <label>CPF</label>
        <input type='text' class='form-control cpf-mask' name='cpf' value="{{Input::old('cpf')}}"/>
    </div>
    <div class='form-group'>
        <label>RG</label>
        <input type='text' class='form-control' name='rg' value="{{Input::old('rg')}}"/>
    </div>

    <div class='form-group'>
        <label>Órgão Expedidor do RG (Ex: SSP/SC)</label>
        <input type='text' class='form-control' name='orgao_expedidor' value="{{Input::old('orgao_expedidor')}}"/>
    </div>
    <div class='form-group'>
        <label>Nº Título de Eleitor</label>
        <input type='text' class='form-control' name='titulo_eleitor' value="{{Input::old('titulo_eleitor')}}"/>
    </div>
    <div class='form-group'>
        <label>Nº do Último Recibo do Imposto de Renda (Deixe em branco caso não tenha declarado)</label>
        <input type='text' class='form-control irpf-mask' name='recibo_ir' value="{{Input::old('recibo_ir')}}"/>
    </div>
    <div class='form-group'>
        <label>PIS</label>
        <input type='text' class='form-control pis-mask' name='pis' value="{{Input::old('pis')}}"/>
    </div>
    <div class='form-group'>
        <label>CEP</label>
        <input type='text' class='form-control cep-mask' name='cep' value="{{Input::old('cep')}}"/>
    </div>
    <div class='form-group'>
        <label>Estado</label>

        <select class="form-control" name='socio[id_uf]'>
            <option value="">Selecione uma opção</option>
            @foreach(\App\Uf::get() as $uf)
            <option value="{{$uf->id}}" {{Input::old('id_uf') == $uf->id ? 'selected' : null}}>{{$uf->nome}}</option>
            @endforeach
        </select> 
    </div>
    <div class='form-group'>
        <label>Cidade</label>
        <input type='text' class='form-control' name='cidade' value="{{Input::old('cidade')}}"/>
    </div>
    <div class='form-group'>
        <label>Endereço</label>
        <input type='text' class='form-control' name='endereco' value="{{Input::old('endereco')}}"/>
    </div>
    <div class='form-group'>
        <label>Bairro</label>
        <input type='text' class='form-control' name='bairro' value="{{Input::old('bairro')}}"/>
    </div>
    <div class='form-group'>
        <label>Pró-Labore (Deixe em branco caso não receba pró-labore)</label>
        <input type='text' class='form-control dinheiro-mask' name='pro_labore' value="{{Input::old('pro_labore')}}"/>
    </div>
    <input type='hidden' name='principal' value="0"/>
    <div class='form-group'>
        <input type='submit' value="Cadastrar" class='btn btn-primary' />
    </div>
</form>
@stop