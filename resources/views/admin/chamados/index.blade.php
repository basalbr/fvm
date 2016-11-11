@extends('layouts.admin')
@section('header_title', 'Chamados')
@section('js')
@parent
<script type="text/javascript" src="{{url('public/js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript" src="{{url('public/js/bootstrap-datepicker.pt-BR.min.js')}}"></script>
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
<h1>Chamados</h1>
<hr class="dash-title">
<div class="card">
    <h3>Filtros de Pesquisa</h3>
    <form class="form-inline">
        <div class="form-group" style="width: 300px">
            <label>Título</label>
            <div class="clearfix"></div>
            <input type="text" class="form-control" name='titulo' value='{{Input::get('titulo')}}'/>
        </div>
        <div class="form-group" style="width: 110px">
            <label>De</label>
            <input type="text" class="form-control date-mask" name='de' value='{{Input::get('de')}}'/>
        </div>
        <div class="form-group" style="width: 110px">
            <label>Até</label>
            <input type="text" class="form-control date-mask" name='ate' value='{{Input::get('ate')}}'/>
        </div>
        <div class="form-group" style="width: 250px">
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
        <div class="form-group"  style="width: 50px">
            <label>&zwnj;</label>
            <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> Pesquisar</button>
        </div>
        <div class="clearfix"></div>
    </form>
    <br />
    <h3>Lista de chamados</h3>
    <table class='table'>
        <thead>
            <tr>
                <th>Status</th>
                <th>Usuário</th>
                <th>Título</th>
                <th>Aberto em</th>
                <th>Última mensagem em</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if($chamados->count())
            @foreach($chamados as $chamado)
            <tr>
                <td>{{$chamado->status}}</td>
                <td>{{$chamado->usuario->nome}}</td>
                <td>{{$chamado->titulo}}</td>
                <td>{{$chamado->created_at->format('d/m/Y - H:i:s')}}</td>
                <td>{{$chamado->updated_at->format('d/m/Y - H:i:s')}}</td>
                <td><a class="btn btn-primary" href="{{route('visualizar-chamados', ['id' => $chamado->id])}}">Responder</a></td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="3">Nenhum chamado encontrado</td>
            </tr>
            @endif
        </tbody>
    </table>
    <a class='btn btn-primary' href='{{route('cadastrar-chamado')}}'>Abrir chamado</a><br />
</div>

@stop