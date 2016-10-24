@extends('layouts.admin')
@section('header_title', 'Empresas')
@section('js')
@parent
<script>
    $(function () {
        $('#verificar-empresa').on('click', function () {
            $('#empresa-modal').modal('show');
        });
        $('#validar-empresa').on('click', function (e) {
            if (!$('input[name="santa_catarina"]:checked').val() || !$('input[name="funcionarios"]:checked').val() || !$('input[name="simples_nacional"]:checked').val()) {
                e.preventDefault();
                $('#empresa-modal').modal('hide');
                $('#erro-modal').modal('show');
            }
            if ($('input[name="santa_catarina"]:checked').val() == 'nao' || $('input[name="funcionarios"]:checked').val() == 'sim' || $('input[name="simples_nacional"]:checked').val() == 'nao') {
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
<h1>Empresas</h1>
<p>Abaixo estão as empresas cadastradas por você, caso queira editar ou visualizar alguma informação, clique em editar.<br/>Se você deseja gerenciar os sócios de uma empresa, clique em sócios.</p>
<hr class="dash-title">
<div class="card">
    <h3>Lista de empresas</h3>
    <table class='table'>
        <thead>
            <tr>
                <th>E-mail</th>
                <th>Nome Fantasia</th>
                <th>Razão Social</th>
                <th>CNPJ</th>
                <th>Nº de Sócios</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if($empresas->count())
            @foreach($empresas as $empresa)
            <tr>
                <td>{{$empresa->usuario->email}}</td>
                <td>{{$empresa->nome_fantasia}}</td>
                <td>{{$empresa->razao_social}}</td>
                <td>{{$empresa->cpf_cnpj}}</td>
                <td>{{$empresa->socios()->count()}}</td>
                <td>
                    <a class='btn btn-warning' href="{{route('editar-empresa-admin', ['id' => $empresa->id])}}">Visualizar</a>
                    <a class='btn btn-danger' href="{{$empresa->id}}">Remover</a>
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
    <a class='btn btn-primary'  id="verificar-empresa">Cadastrar uma empresa</a><br />
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
                        <label>Você possui funcionários?</label>
                        <div class="clearfix"></div>
                        <label class='form-control'><input type="radio" name="funcionarios" value="sim"/> Sim</label>
                        <label class='form-control'><input type="radio" name="funcionarios" value="nao"/> Não</label>
                    </div> 
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
                <a id='validar-empresa' href='{{route('cadastrar-abertura-empresa')}}' class="btn btn-success">Continuar</a>
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
                <p>Desculpe, mas por enquanto só atendemos empresas optantes do Simples Nacional, registradas em Santa Catarina e que não possuem funcionários.</p>
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar Janela</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@stop