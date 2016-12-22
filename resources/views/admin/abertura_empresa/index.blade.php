@extends('layouts.admin')
@section('header_title', 'Abertura de Empresas')
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

<div class="card">
    <h1>Processos de abertura de empresa</h1>
    <h3>Filtros de Pesquisa</h3>
    <form class="form-inline">
        <div class="form-group" style="width: 200px">
            <label>Usuário</label>
            <div class="clearfix"></div>
            <input type="text" class="form-control" name='usuario' value='{{Input::get('usuario')}}'/>
        </div>
        <div class="form-group" style="width: 200px">
            <label>Nome Preferencial</label>
            <div class="clearfix"></div>
            <input type="text" class="form-control" name='nome_preferencial' value='{{Input::get('nome_preferencial')}}'/>
        </div>
        
        <div class="form-group" style="width: 150px">
            <label>Status do Processo</label>
            <select name="status_processo" class="form-control">
                <option value="">Todos</option>
                <option value="Atenção" {{Input::get('status_processo') == 'Atenção' ? 'selected' : ''}}>Atenção</option>
                <option value="Cancelado" {{Input::get('status_processo') == 'Atenção' ? 'selected' : ''}}>Cancelado</option>
                <option value="Em Processamento" {{Input::get('status_processo') == 'Em Processamento' ? 'selected' : ''}}>Em Processamento</option>
                <option value="Concluído" {{Input::get('status_processo') == 'Concluído' ? 'selected' : ''}}>Concluído</option>
                <option value="Novo" {{Input::get('status_processo') == 'Novo' ? 'selected' : ''}}>Novo</option>
            </select>
        </div>
        <div class="form-group" style="width: 150px">
            <label>Status do Pagamento</label>
            <select name="status_pagamento" class="form-control">
                <option value="">Todos</option>
                <option value="Pendente" {{Input::get('status_pagamento') ? 'selected' : ''}}>Pendente</option>
                <option value="Cancelada" {{Input::get('status_pagamento') == 'Cancelada' ? 'selected' : ''}}>Cancelada</option>
                <option value="Paga" {{Input::get('status_pagamento') == 'Paga' ? 'selected' : ''}}>Paga</option>
                <option value="Em Análise" {{Input::get('status_pagamento') == 'Em Análise' ? 'selected' : ''}}>Em Análise</option>
            </select>
        </div>
        <div class="form-group" style="width: 200px">
            <label>Ordenar por</label>
            <select name="ordenar" class="form-control">
                <option value="">Mais Recente</option>
                <option value="usuario_asc" {{Input::get('ordenar') == 'usuario_asc' ? 'selected' : ''}}>Usuário - A/Z</option>
                <option value="usuario_desc" {{Input::get('ordenar') == 'usuario_desc' ? 'selected' : ''}}>Usuário - Z/A</option>
                <option value="status_pagamento" {{Input::get('ordenar') == 'status_pagamento' ? 'selected' : ''}}>Status Pagamento</option>
                <option value="status_processo" {{Input::get('ordenar') == 'status_processo' ? 'selected' : ''}}>Status Processo</option>
                <option value="nome_preferencial_asc" {{Input::get('ordenar') == 'nome_preferencial_asc' ? 'selected' : ''}}>Nome Preferencial - A/Z</option>
                <option value="nome_preferencial_desc" {{Input::get('ordenar') == 'nome_preferencial_desc' ? 'selected' : ''}}>Nome Preferencial - Z/A</option>
            </select>
        </div>
        <div class="clearfix"></div>
        <div class="form-group"  style="width: 50px">
            <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> Pesquisar</button>
        </div>
        <div class="clearfix"></div>
    </form>
    <br />
    <h3>Lista de processos de abertura de empresa</h3>

    <div class='table-responsive'>
        <table class='table'>
            <thead>
                <tr>
                    <th>Usuário</th>
                    <th>Nome Preferencial</th>
                    <th>Status do Processo</th>
                    <th>Status do Pagamento</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @if($empresas->count())
                @foreach($empresas as $empresa)
                <tr>
                    <td>{{str_limit($empresa->usuario->nome, 25)}}</td>
                    <td>{{str_limit($empresa->nome_empresarial1, 25)}}</td>
                    <td>{{$empresa->status}}</td>
                    <td>{{$empresa->pagamento->status}}</td>
                    <td>
                        <a class='btn btn-primary' href="{{route('editar-abertura-empresa-admin', ['id' => $empresa->id])}}"><span class='fa fa-search'></span> Visualizar</a>
                        <a class='btn btn-danger' href="{{route('deletar-abertura-empresa-admin', ['id' => $empresa->id])}}"><span class='fa fa-remove'></span> Remover</a>
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
    </div>
</div>
@stop