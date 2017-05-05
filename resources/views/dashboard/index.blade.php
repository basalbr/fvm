@extends('layouts.dashboard')


@section('main')
<div class='card'>
    <h1>Central do Cliente</h1>
    <h3>Atalhos</h3>
    <p><b>Seja bem vindo {{Auth::user()->nome}}</b>, utilize os botões no menu esquerdo para navegar em nosso sistema ou selecione uma das opções abaixo para acessar rapidamente as funcionalidades.</p>
    <br />
    

    <div class='col-md-4'>
        <a href='{{route('cadastrar-abertura-empresa')}}' class='shortcut blue'>
            <div class='big-icon'><span class='fa fa-child'></span></div>
            <h3 class='text-center'>Abrir Empresa</h3>
        </a>
    </div>
    <div class='col-md-4'>
        <a href='{{route('cadastrar-empresa')}}' class='shortcut green'>
            <div class='big-icon'><span class='fa fa-exchange'></span></div>
            <h3 class='text-center'>Migrar Empresa</h3>
        </a>
    </div>
    <div class='col-md-4'>
        <a href='{{route('listar-processos')}}' class='shortcut mint'>
            <div class='big-icon'><span class='fa fa-file'></span></div>
            <div class='contador'>{{$qtde_apuracoes}}</div>
            <h3 class='text-center'>Apurações em aberto</h3>
        </a>
    </div>
  
      <div class='col-md-4'>
        <a href='{{route('listar-chamados-usuario')}}' class='shortcut blue'>
            <div class='big-icon'><span class='fa fa-envelope'></span></div>
            <div class='contador'>{{$qtde_chamados}}</div>
            <h3 class='text-center'>Chamados</h3>
        </a>
    </div>
    <div class='col-md-4'>
        <a href='{{route('listar-pagamentos-pendentes')}}' class='shortcut orange'>
            <div class='big-icon'><span class='fa fa-credit-card'></span></div>
            <div class='contador'>{{$qtde_pagamentos}}</div>
            <h3 class='text-center'>Pagamentos Pendentes</h3>
        </a>
    </div>
    <div class='col-md-4'>
        <a href='{{route('editar-usuario')}}' class='shortcut green'>
            <div class='big-icon'><span class='fa fa-user'></span></div>
            <h3 class='text-center'>Meus dados</h3>
        </a>
    </div>
    
    <div class='clearfix'></div>
</div>
@if($notificacoes->count())

@endif
@stop
@section('modal')

<div class="modal fade" id="atalho-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="width: 807px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Bem vindo à WEBContabilidade</h4>
                <div class="clearfix"></div>
            </div>
            <div class="modal-body">
                <br />
                <p>Olá <b>{{auth()->user()->nome}}</b>, seja bem vindo à WEBContabilidade.</p>
                <p>Pudemos notar que você ainda não fez nenhuma <b>solicitação de abertura de empresa</b> ou para <b>migrar sua empresa</b>.</p>
                <p>Escolha uma opção abaixo para prosseguir:</p>
                <br />
                <div class="clearfix"></div>
                <a href='{{route('cadastrar-abertura-empresa')}}' class='btn btn-success btn-lg'><span class='fa fa-folder-open-o'></span> desejo abrir uma empresa</a>
                <a href='{{route('cadastrar-empresa')}}' class='btn btn-primary btn-lg'><span class='fa fa-paper-plane'></span> desejo migrar minha empresa</a>
                <a href='{{route('cadastrar-chamado')}}' class='btn btn-info btn-lg'><span class='fa fa-question'></span> desejo tirar dúvidas</a>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@stop