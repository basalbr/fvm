@extends('layouts.dashboard')
@section('header_title', 'Empresas')
@section('js')
@parent
<script>
    $(function () {
        $('#verificar-empresa').on('click', function () {
            $('#empresa-modal').modal('show');
        });
        $('#validar-empresa').on('click', function (e) {
            if (!$('input[name="santa_catarina"]:checked').val() || !$('input[name="simples_nacional"]:checked').val()) {
                e.preventDefault();
                $('#empresa-modal').modal('hide');
                $('#erro-modal').modal('show');
            }
            if ($('input[name="santa_catarina"]:checked').val() == 'nao' || $('input[name="simples_nacional"]:checked').val() == 'nao') {
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


<div class="card">
    <h1>Empresas</h1>
    <p>Abaixo estão as empresas cadastradas por você, caso queira editar ou visualizar alguma informação, clique em editar empresa.<br/>Se você deseja gerenciar os sócios de uma empresa, clique em listar sócios.<br />Empresas em processo de análise não podem ser editadas.</p>
    <h3>Lista de empresas</h3>
    <table class='table table-hover table-striped'>
        <thead>
            <tr>
                <th>Nome Fantasia</th>
                <th class="hidden-xs hidden-sm">Razão Social</th>
                <th class="visible-lg">CNPJ</th>
                <th class="visible-lg">Nº de Sócios</th>
                <th class="hidden-xs hidden-sm">Status</th>
                <th>Opções</th>
            </tr>
        </thead>
        <tbody>
            @if($empresas->count())
            @foreach($empresas as $empresa)
            <tr>
                <td>{{$empresa->nome_fantasia}}</td>
                <td class="hidden-xs hidden-sm">{{$empresa->razao_social}}</td>
                <td class="visible-lg">{{$empresa->cpf_cnpj}}</td>
                <td class="visible-lg">{{$empresa->socios()->count()}}</td>
                <td class="hidden-xs hidden-sm">{{$empresa->status}}</td>
                <td>
                    @if($empresa->status != 'Em Análise')
                    <a class='btn btn-info' href="{{route('cadastrar-socio', [$empresa->id])}}"><span class="fa fa-plus"></span> Cadastrar Sócio</a>
                    <a class='btn btn-primary' href="{{route('listar-socios', [$empresa->id])}}"><span class="fa fa-list-alt"></span> Listar Sócios</a>
                    @endif
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="6">Nenhum registro cadastrado</td>
            </tr>
            @endif
        </tbody>
    </table>
    <a class='btn btn-primary' id="verificar-empresa"><span class="fa fa-exchange"></span> <span class="visible-lg-inline">migrar Empresa para webcontabilidade</span><span class="hidden-lg">migrar Empresa</span></a>
    <a class='btn btn-success' href='{{route('cadastrar-abertura-empresa')}}'><span class="fa fa-child"></span> <span class="visible-lg-inline">solicitar abertura de empresa</span><span class="hidden-lg">abrir empresa</span></a>
</div>
@stop
@section('modal')
<div class="modal fade" id="empresa-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Cadastrar empresa</h4>
                <div class="clearfix"></div>
            </div>
            <div class="modal-body">
                <p>Olá, por favor responda as perguntas abaixo e clique em continuar</p>
                <form>
                    <div class="form-group">
                        <label>Sua empresa é optante do Simples Nacional?</label>
                        <div class="clearfix"></div>
                        <label class='form-control'><input type="radio" name="simples_nacional" value="sim"/> Sim</label>
                        <label class='form-control'><input type="radio" name="simples_nacional" value="nao"/> Não</label>
                    </div> 
                    <div class="form-group">
                        <label>Sua empresa é registrada em Santa Catarina?</label>
                        <div class="clearfix"></div>
                        <label class='form-control'><input type="radio" name="santa_catarina" value="sim"/> Sim</label>
                        <label class='form-control'><input type="radio" name="santa_catarina" value="nao"/> Não</label>
                    </div> 
                </form>
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <a id='validar-empresa' href='{{route('cadastrar-empresa')}}' class="btn btn-success">Continuar</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar Janela</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="erro-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Desculpe-nos</h4>
                <div class="clearfix"></div>
            </div>
            <div class="modal-body">
                <p>Desculpe, mas por enquanto só atendemos empresas optantes do Simples Nacional e registradas em Santa Catarina.</p>
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar Janela</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@stop