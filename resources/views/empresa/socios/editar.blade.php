@extends('layouts.dashboard')
@section('main')
@section('header_title', 'Editar Sócio')
<h1>Editar Sócio</h1>
<p>Após modificar os campos abaixo, clique em "salvar alterações" para atualizar as informações do sócio no sistema.</p>
<hr class='dash-title' />

<div class='col-xs-12'>
    <div class='card'>
        @if($errors->has())
        <div class="alert alert-warning shake">
            <b>Atenção</b><br />
            @foreach ($errors->all() as $error)
            {{ $error }}<br />
            @endforeach
        </div>
        @endif
        <h3>Informações</h3>
        <form method="POST" action="">
            {{ csrf_field() }}
            <div class='form-group'>
                <label>Nome Completo</label>
                <input type='text' class='form-control' name='nome' value="{{$socio->nome}}" />
            </div> 

            <div class='form-group'>
                <label>Telefone Principal</label>
                <input type='text' class='form-control fone-mask' name='telefone' value="{{$socio->telefone}}" />
            </div>

            <div class='form-group'>
                <label>CPF</label>
                <input type='text' class='form-control cpf-mask' name='cpf' value="{{$socio->cpf}}"/>
            </div>
            <div class='form-group'>
                <label>RG</label>
                <input type='text' class='form-control' name='rg' value="{{$socio->rg}}"/>
            </div>

            <div class='form-group'>
                <label>Órgão Expedidor do RG (Ex: SSP/SC)</label>
                <input type='text' class='form-control' name='orgao_expedidor' value="{{$socio->orgao_expedidor}}"/>
            </div>
            <div class='form-group'>
                <label>Nº Título de Eleitor</label>
                <input type='text' class='form-control' name='titulo_eleitor' value="{{$socio->titulo_eleitor}}"/>
            </div>
            <div class='form-group'>
                <label>Nº do Último Recibo do Imposto de Renda (Deixe em branco caso não tenha declarado)</label>
                <input type='text' class='form-control irpf-mask' name='recibo_ir' value="{{$socio->recibo_ir}}"/>
            </div>
            <div class='form-group'>
                <label>PIS</label>
                <input type='text' class='form-control pis-mask' name='pis' value="{{$socio->pis}}"/>
            </div>
            <div class='form-group'>
                <label>CEP</label>
                <input type='text' class='form-control cep-mask' name='cep' value="{{$socio->cep}}"/>
            </div>
            <div class='form-group'>
                <label>Estado</label>

                <select class="form-control" name='id_uf'>
                    <option value="">Selecione uma opção</option>
                    @foreach(\App\Uf::get() as $uf)
                    <option value="{{$uf->id}}" {{$socio->id_uf == $uf->id ? 'selected' : null}}>{{$uf->nome}}</option>
                    @endforeach
                </select> 
            </div>
            <div class='form-group'>
                <label>Cidade</label>
                <input type='text' class='form-control' name='cidade' value="{{$socio->cidade}}"/>
            </div>
            <div class='form-group'>
                <label>Endereço</label>
                <input type='text' class='form-control' name='endereco' value="{{$socio->endereco}}"/>
            </div>
            <div class='form-group'>
                <label>Bairro</label>
                <input type='text' class='form-control' name='bairro' value="{{$socio->bairro}}"/>
            </div>
            <div class='form-group'>
                <label>Pró-Labore (Deixe em branco caso não receba pró-labore)</label>
                <input type='text' class='form-control dinheiro-mask' name='pro_labore' value="{{$socio->pro_labore}}"/>
            </div>
            <div class='form-group'>
                <input type='submit' value="Salvar alterações" class='btn btn-primary' />
            </div>
            <div class="clearfix"></div>
        </form>
    </div>
</div>
@stop