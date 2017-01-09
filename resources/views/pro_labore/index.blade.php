@extends('layouts.dashboard')
@section('header_title', 'Pró-Labore - Histórico')
@section('js')
@parent
<script type="text/javascript" src="{{url(public_path().'js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript" src="{{url(public_path().'js/bootstrap-datepicker.pt-BR.min.js')}}"></script>
<script type="text/javascript"  language="javascript">
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
    <h1>Pró-labore</h1>
    <p>Abaixo está listado o histórico de pró-labore por sócio.<br />Utilize os filtros abaixo caso queira refinar a lista de pró-labore.</p>
    <h3>Filtros de Pesquisa</h3>
    <form class="form-inline form-pesquisa">
        <div class="form-group" style="width: 200px">
            <label>Empresa</label>
            <select name="empresa" class="form-control">
                <option value="" {{!Input::get('empresa') ? 'selected' : ''}}>Todas</option>
                @foreach(Auth::user()->pessoas()->orderBy('nome_fantasia')->get() as $empresa)
                <option value="{{$empresa->id}}" {{Input::get('empresa') == $empresa->id ? 'selected' : ''}}>{{$empresa->nome_fantasia}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group" style="width: 200px">
            <label>Sócio</label>
            <select name="socio" class="form-control">
                <option value="" {{!Input::get('socio') ? 'selected' : ''}}>Todos</option>
                @foreach(Auth::user()->pessoas()->get() as $empresa)
                @foreach($empresa->socios()->orderBy('nome')->get() as $socio)
                <option value="{{$socio->id}}" {{Input::get('socio') == $socio->id ? 'selected' : ''}}>{{$socio->nome}}</option>
                @endforeach
                @endforeach
            </select>
        </div>
        <div class="form-group" style="width: 220px">
            <label>Ordenar por</label>
            <select name="ordenar" class="form-control">
                <option value="created_at_desc" {{Input::get('ordenar') == 'created_at_desc' ? 'selected' : ''}}>Mais novo</option>
                <option value="created_at_asc" {{Input::get('ordenar') == 'created_at_asc' ? 'selected' : ''}}>Mais antigo</option>
                <option value="empresa_asc" {{Input::get('ordenar') == 'empresa_asc' ? 'selected' : ''}}>Empresa - A/Z</option>
                <option value="empresa_desc" {{Input::get('ordenar') == 'empresa_desc' ? 'selected' : ''}}>Empresa - Z/A</option>
                <option value="socio_asc" {{Input::get('ordenar') == 'socio_asc' ? 'selected' : ''}}>Sócio - A/Z</option>
                <option value="socio_desc" {{Input::get('ordenar') == 'socio_desc' ? 'selected' : ''}}>Sócio - Z/A</option>
            </select>
        </div>
        <div class="form-group"  style="width: 50px">
            <label>&zwnj;</label>
            <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> Pesquisar</button>
        </div>
        <div class="clearfix"></div>
    </form>
    <br />
    <h3>Lista de Pró-labore</h3>
    <table class='table table-hover table-striped'>
        <thead>
            <tr>
                <th>Competência</th>
                <th>Nome</th>
                <th>Empresa</th>
                <th>Valor do pró-labore</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if($pro_labores->count())
            @foreach($pro_labores as $pro_labore)
            <tr>
                <td>{{date_format(date_create($pro_labore->competencia.'T00:00:00'),'m/Y')}}</td>
                <td>{{$pro_labore->socio->nome}}</td>
                <td>{{$pro_labore->socio->pessoa->nome_fantasia}}</td>
                <td>R$ {{number_format($pro_labore->valor_pro_labore,2,',','.')}}</td>
                <td><a class='btn btn-primary' href="{{route('visualizar-pro-labore-socio', ['id' => $pro_labore->socio->id,'pro_labore'=>$pro_labore->id])}}">Visualizar</a></td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="5">Nenhum registro cadastrado</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
@stop