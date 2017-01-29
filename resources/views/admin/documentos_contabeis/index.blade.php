@extends('layouts.admin')
@section('js')
@parent
<script type="text/javascript" src="{{url(public_path().'js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript" src="{{url(public_path().'js/bootstrap-datepicker.pt-BR.min.js')}}"></script>
<script type="text/javascript" language="javascript">
$(function () {
    $('.date-mask').on('keypress', function () {
        return false;
    });
    $('.date-mask').datepicker({
        language: 'pt-BR',
        autoclose: true,
        format: 'dd/mm/yyyy',
        todayBtn: 'linked'
    });
});
</script>
@stop
@section('header_title', 'Documentos Contábeis')
@section('main')

<div class="card">
    <h1>Documentos Contábeis</h1>
    <p>Para visualizar os detalhes de uma apuração ou enviar informações adicionar, clique em visualizar.</p>
    <h3>Filtros de Pesquisa
    </h3>
    <form class="form-inline form-pesquisa">
        <div class="form-group" style="width: 200px">
            <label>Empresa</label>
          <input type="text" class="form-control" name='empresa' value='{{Input::get('empresa')}}'/>
        </div>
        <div class="form-group" style="width: 130px">
            <label>Período de</label>
            <input type="text" class="form-control date-mask" name='competencia_de'
                   value='{{Input::get('periodo_de')}}'/>
        </div>
        <div class="form-group" style="width: 130px">
            <label>Período até</label>
            <input type="text" class="form-control date-mask" name='competencia_ate'
                   value='{{Input::get('periodo_ate')}}'/>
        </div>
        <div class="form-group" style="width: 200px">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="" {{Input::get('status') ? 'selected' : ''}}>Todos</option>
                <option value="pendente" {{Input::get('status') == 'pendente' ? 'selected' : ''}}>Pendente</option>
                <option value="sem_movimento" {{Input::get('status') == 'sem_movimento' ? 'selected' : ''}}>Sem Movimento</option>
                <option value="documentos_enviados" {{Input::get('status') == 'documentos_enviados' ? 'selected' : ''}}>Documentos Enviados</option>
                <option value="contabilizado" {{Input::get('status') == 'contabilizado' ? 'selected' : ''}}>Contabilizado</option>
            </select>
        </div>
        <div class="form-group" style="width: 220px">
            <label>Ordenar por</label>
            <select name="ordenar" class="form-control">
                <option value="periodo_desc" {{Input::get('ordenar') == 'periodo_desc' ? 'selected' : ''}}>Período - Z/A</option>
                <option value="periodo_asc" {{Input::get('ordenar') == 'periodo_asc' ? 'selected' : ''}}>Período - A/Z</option>
                <option value="atualizado_desc" {{Input::get('ordenar') == 'atualizado_desc' ? 'selected' : ''}}>Mais Recente</option>
                <option value="atualizado_asc" {{Input::get('ordenar') == 'atualizado_asc' ? 'selected' : ''}}>Mais Antigo</option>

            </select>
        </div>
        <div class="clearfix"></div>
        <div class="form-group" style="width: 50px">
            <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> Pesquisar</button>
        </div>
        <div class="clearfix"></div>
    </form>
    <br/>
    <h3>Lista de documentos contábeis</h3>
    <table class='table table-hover table-striped'>
        <thead>
            <tr>
                <th>Período</th>
                <th>Empresa</th>
                <th>Status</th>
                <th>Última Atualização</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if($processos->count())
            @foreach($processos as $processo)
            <tr>
                <td>{{$processo->periodo->format('m/Y')}}</td>
                <td>{{$processo->pessoa->nome_fantasia}}</td>
                <td>{{$processo->status_formatado()}}</td>
                <td>{{$processo->updated_at->format('d/m/Y - H:i')}}</td>
                <td><a class='btn btn-primary' href="{{route('listar-documento-contabil-admin',[$processo->id])}}"><span class="fa fa-search"></span> Visualizar</a></td>
            </tr>

            @endforeach
            @else
            <tr>
                <td colspan="4">Nenhum registro encontrado</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
@stop