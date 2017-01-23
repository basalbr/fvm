@extends('layouts.dashboard')
@section('js')
@parent
<script type='text/javascript'>
    $(function () {
        $('#solicitar-alteracao').on('click', function (e) {
            e.preventDefault();
            $('#alteracao-modal').modal('show');
        });
    });
</script>
@stop
@section('main')
<div class="card">
    <h1>Alterações</h1>
    <p>Abaixo estão as solicitações de alteração. Caso deseje alterar algum dado cadastral ou contratual, clique em solicitar alteração.</p>
    <h3>Lista de alterações</h3>
    <table class='table table-hover table-striped'>
        <thead>
            <tr>
                <th>Descrição</th>
                <th>Status</th>
                <th>Status do Pagamento</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if($alteracoes->count())
            @foreach($alteracoes as $alteracao)
            <tr>
                <td>{{$alteracao->tipo->descricao}}</td>
                <td>{{$alteracao->status}}</td>
                <td>{{$alteracao->pagamento->status}}</td>
                <td>
                    {!!$alteracao->botao_pagamento()!!}
                    <a href='{{route('visualizar-solicitacao-alteracao',[$id_empresa, $alteracao->id])}}' class='btn btn-info'><span class='fa fa-search'></span> Visualizar</a>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="3">Nenhum registro cadastrado</td>
            </tr>
            @endif
        </tbody>
    </table>
    <a class='btn btn-success' href='#' id='solicitar-alteracao'><span class="fa fa-plus"></span> Solicitar alteração</a>
    <a href="{{URL::previous()}}" class="btn btn-primary"><span class='fa fa-history'></span> Voltar</a>
</div>
@stop
@section('modal')

<div class="modal fade" id="alteracao-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="width: 807px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Escolha uma opção</h4>
                <div class="clearfix"></div>
            </div>
            <div class="modal-body">
                <br />
                <p>Escolha uma das opções abaixo para prosseguir com a solicitação.</p>
                <br />
                <div class="clearfix"></div>
                <div class='list-group'>
                    @foreach($tipo_alteracoes as $tipo)
                    <a href='{{route('cadastrar-solicitacao-alteracao',[$id_empresa, $tipo->id])}}' class='list-group-item'>{{$tipo->descricao}}</a>
                    @endforeach
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@stop