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
@section('header_title', 'Apurações')
@section('main')

<div class="card">
    <h1>Apurações</h1>
    <p>Para visualizar os detalhes de uma apuração ou enviar informações adicionar, clique em visualizar.</p>
    <h3>Filtros de Pesquisa <small><a href=''>mostrar</a></small></h3>
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
            <label>Imposto</label>
            <select name="imposto" class="form-control">
                <option value="" {{!Input::get('imposto') ? 'selected' : ''}}>Todos</option>
                @foreach(\App\Imposto::orderBy('nome')->get() as $imposto)
                <option value="{{$imposto->id}}" {{Input::get('imposto') == $imposto->id ? 'selected' : ''}}>{{$imposto->nome}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group" style="width: 130px">
            <label>Competência de</label>
            <input type="text" class="form-control date-mask" name='competencia_de' value='{{Input::get('competencia_de')}}'/>
        </div>
        <div class="form-group" style="width: 130px">
            <label>Competência até</label>
            <input type="text" class="form-control date-mask" name='competencia_ate' value='{{Input::get('competencia_ate')}}'/>
        </div>
        <div class="form-group" style="width: 130px">
            <label>Vencimento de</label>
            <input type="text" class="form-control date-mask" name='vencimento_de' value='{{Input::get('vencimento_de')}}'/>
        </div>
        <div class="form-group" style="width: 130px">
            <label>Vencimento até</label>
            <input type="text" class="form-control date-mask" name='vencimento_ate' value='{{Input::get('vencimento_ate')}}'/>
        </div>
        <div class="form-group" style="width: 160px">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="" {{Input::get('status') ? 'selected' : ''}}>Todos</option>
                <option value="aberto" {{Input::get('status') == 'aberto' ? 'selected' : ''}}>Aberto</option>
                <option value="cancelado" {{Input::get('status') == 'cancelado' ? 'selected' : ''}}>Cancelado</option>
                <option value="concluido" {{Input::get('status') == 'concluido' ? 'selected' : ''}}>Concluído</option>
                <option value="novo" {{Input::get('status') == 'novo' ? 'selected' : ''}}>Novo</option>
            </select>
        </div>
        <div class="form-group" style="width: 220px">
            <label>Ordenar por</label>
            <select name="ordenar" class="form-control">
                <option value="vencimento_desc" {{Input::get('ordenar') == 'atualizado_desc' ? 'selected' : ''}}>Vencimento</option>
                <option value="competencia_desc" {{Input::get('ordenar') == 'competencia_desc' ? 'selected' : ''}}>Competência</option>

            </select>
        </div>
                <div class="clearfix"></div>
        <div class="form-group"  style="width: 50px">
            <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> Pesquisar</button>
        </div>
        <div class="clearfix"></div>
    </form>
    <br />
    <h3>Lista de apurações</h3>
    <table class='table table-hover table-striped'>
        <thead>
            <tr>
                <th>Empresa</th>
                <th>Imposto</th>
                <th>Competência</th>
                <th>Vencimento em</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if($processos->count())
            @foreach($processos as $processo)
            <tr>
                <td>{{$processo->pessoa->nome_fantasia}}</td>
                <td>{{$processo->imposto->nome}}</td>
                <td>{{$processo->competencia_formatado()}}</td>
                <td>{{$processo->vencimento_formatado()}}</td>
                <td>{{$processo->status}}</td>
                <td><a class='btn btn-primary' href="{{route('visualizar-processo-admin', ['id' => $processo->id])}}"><span class="fa fa-search"></span> Visualizar</a></td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="6">Nenhum registro cadastrado</td>
            </tr>
            @endif
        </tbody>
    </table>
    {!! str_replace('/?', '?', $processos->render()) !!}
    <div class="clearfix"></div>
</div>
@stop