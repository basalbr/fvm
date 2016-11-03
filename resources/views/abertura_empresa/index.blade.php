@extends('layouts.dashboard')
@section('header_title', 'Abertura de Empresas')
@section('js')
@parent
<script>
$(function(){
   $('#verificar-empresa').on('click', function(){
      $('#empresa-modal').modal('show'); 
   });
   $('#validar-empresa').on('click', function(e){
       if(!$('input[name="santa_catarina"]:checked').val() || !$('input[name="funcionarios"]:checked').val() || !$('input[name="simples_nacional"]:checked').val()){
          e.preventDefault();
          $('#empresa-modal').modal('hide'); 
          $('#erro-modal').modal('show');
      } 
      if($('input[name="santa_catarina"]:checked').val() == 'nao' || $('input[name="funcionarios"]:checked').val() == 'sim' || $('input[name="simples_nacional"]:checked').val() == 'nao'){
          e.preventDefault();
          $('#empresa-modal').modal('hide'); 
          $('#erro-modal').modal('show');
      } 
      return true;
   });
});
</script>
@stop
@section('main')
<h1>Processos de abertura de empresa</h1>
<p>Abaixo estão as solicitações de abertura de empresa feita por você.</p>
<p><b>É necessário efetuar o pagamento de R$ 49,90 referente ao processo para que possamos abrir a empresa para você.</b></p>
<hr class="dash-title">
<div class="card">
    <h3>Lista de processos de abertura de empresa</h3>
    <table class='table'>
        <thead>
            <tr>
                <th>Nome Preferencial</th>
                <th>Nome do Sócio Principal</th>
                <th>Status do Processo</th>
                <th>Status do Pagamento</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if($empresas->count())
            @foreach($empresas as $empresa)
            <tr>
                <td>{{$empresa->nome_empresarial1}}</td>
                <td>{{$empresa->socios()->where('principal','=',1)->first()->nome}}</td>
                <td>{{$empresa->status}}</td>
                <td>{{$empresa->pagamento->status}}</td>
                <td>
                    <a class='btn btn-primary' href="{{route('editar-abertura-empresa', ['id' => $empresa->id])}}">Visualizar Processo</a>
                    {!!$empresa->botao_pagamento()!!}
                    @if($empresa->status != 'Concluído' && $empresa->status != 'Cancelado')
                    <a class='btn btn-danger remover-registro' href="{{route('deletar-abertura-empresa',[$empresa->id])}}">Cancelar Processo</a>
                    @endif
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="4">Nenhum registro cadastrado</td>
            </tr>
            @endif
        </tbody>
    </table>
    <a class='btn btn-success' href='{{route('cadastrar-abertura-empresa')}}'>solicitar abertura de empresa</a>
</div>
@stop
