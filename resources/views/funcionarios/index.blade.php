@extends('layouts.dashboard')
@section('header_title', 'Funcionários')
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

<div class="card">
    <h1>Funcionários</h1>
    <p>Selecione uma empresa para ver os funcionários.</p>

    <h3>Lista de empresas</h3>
    <table class='table table-hover table-striped'>
        <thead>
            <tr>
                <th>Nome Fantasia</th>
                <th>Qtde de funcionários</th>
                <th>Limite de funcionários</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if($empresas->count())
            @foreach($empresas as $empresa)
            <tr>
                <td>{{$empresa->nome_fantasia}}</td>
                <td>{{$empresa->funcionarios()->count()}}</td>
                <td>{{$empresa->mensalidade->funcionarios}}</td>
                <td>
                    @if($empresa->status != 'Em Análise')
                        @if($empresa->canRegisterFuncionario())
                    <a class='btn btn-success' href="{{route('cadastrar-funcionario', [$empresa->id])}}"><span class='fa fa-user-plus'></span> Cadastrar Funcionário</a>
                        @endif
                    @if($empresa->funcionarios->count())
                    <a class='btn btn-primary' href="{{route('listar-funcionarios', [$empresa->id])}}"><span class='fa fa-list-alt'></span> Listar Funcionários</a>
                        @endif
                    @endif
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