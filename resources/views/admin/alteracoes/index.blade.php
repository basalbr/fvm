@extends('layouts.admin')
@section('header_title', 'Chamados')
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
@section('main')
<div class="card">
    <h1>Chamados</h1>
    <p>Caso você esteja com dúvidas ou com algum problema, você pode abrir um chamado para que possamos te ajudar.</p>
    <h3>Filtros de Pesquisa</h3>
    <form class="form-inline">
        <div class="form-group" style="width: 250px">
            <label>Título</label>
            <div class="clearfix"></div>
            <input type="text" class="form-control" name='titulo' value='{{Input::get('titulo')}}'/>
        </div>
        <div class="form-group" style="width: 100px">
            <label>De</label>
            <input type="text" class="form-control date-mask" name='de' value='{{Input::get('de')}}'/>
        </div>
        <div class="form-group" style="width: 100px">
            <label>Até</label>
            <input type="text" class="form-control date-mask" name='ate' value='{{Input::get('ate')}}'/>
        </div>
        <div class="form-group" style="width: 150px">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="" {{Input::get('status') ? 'selected' : ''}}>Todos</option>
                <option value="Aberto" {{Input::get('status') == 'Aberto' ? 'selected' : ''}}>Aberto</option>
                <option value="Concluído" {{Input::get('status') == 'Concluído' ? 'selected' : ''}}>Concluído</option>
            </select>
        </div>
        <div class="form-group" style="width: 250px">
            <label>Ordenar por</label>
            <select name="ordenar" class="form-control">
                <option value="atualizado_desc" {{Input::get('ordenar') == 'atualizado_desc' ? 'selected' : ''}}>Mais recente</option>
                <option value="atualizado_asc" {{Input::get('ordenar') == 'atualizado_asc' ? 'selected' : ''}}>Mais antigo</option>
                <option value="titulo_asc" {{Input::get('ordenar') == 'titulo_asc' ? 'selected' : ''}}>Título - A/Z</option>
                <option value="titulo_desc" {{Input::get('ordenar') == 'titulo_desc' ? 'selected' : ''}}>Título - Z/A</option>
            </select>
        </div>
        <div class="clearfix"></div>
        <div class="form-group"  style="width: 50px">
            <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> Pesquisar</button>
        </div>
        <div class="clearfix"></div>
    </form>
    <br />
    <h3>Lista de solicitações de alteração</h3>
    <table class='table table-hover table-striped'>
        <thead>
            <tr>
                <th>Status</th>
                <th>Status Pag.</th>
                <th>Tipo de Alteração</th>
                <th>Empresa</th>
                <th>Atualizado em</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if($alteracoes->count())
            @foreach($alteracoes as $alteracao)
            <tr>
                <td><b>{{$alteracao->status}}</b></td>
                <td><b>{{$alteracao->pagamento->status}}</b></td>
                <td><a href="{{route('editar-tipo-alteracao',[$alteracao->tipo->id])}}">{{$alteracao->tipo->descricao}}</a></td>
                <td><a href="{{route('editar-empresa-admin',[$alteracao->empresa->id])}}">{{$alteracao->empresa->nome_fantasia}}</td>
                <td>{{$alteracao->updated_at->format('d/m/Y H:i')}}</td>
                <td><a class="btn btn-primary" href="{{route('visualizar-solicitacao-alteracao-admin', ['id' => $alteracao->id])}}"><span class="fa fa-search"></span> Visualizar</a></td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="3">Nenhuma solicitação de alteração encontrada</td>
            </tr>
            @endif
        </tbody>
    </table>
    {!! str_replace('/?', '?', $alteracoes->render()) !!}
    <div class='clearfix'></div>
</div>

@stop