@extends('layouts.admin')
@section('header_title', 'Chamados')
@section('main')
<h1>Pró-Labore</h1>
<hr class="dash-title">
<div class="card">
    <h3>Filtros de Pesquisa</h3>
    <form class="form-inline">
        <div class="form-group" style="width: 300px">
            <label>Pergunta</label>
            <div class="clearfix"></div>
            <input type="text" class="form-control" name='pergunta' value='{{Input::get('pergunta')}}'/>
        </div>
        <div class="form-group" style="width: 300px">
            <label>Resposta</label>
            <div class="clearfix"></div>
            <input type="text" class="form-control" name='resposta' value='{{Input::get('resposta')}}'/>
        </div>
        <div class="form-group" style="width: 250px">
            <label>Ordenar por</label>
            <select name="ordenar" class="form-control">
                <option value="pergunta_asc" {{Input::get('ordenar') == 'pergunta_asc' ? 'selected' : ''}}>Pergunta - A/Z</option>
                <option value="pergunta_desc" {{Input::get('ordenar') == 'pergunta_desc' ? 'selected' : ''}}>Resposta - Z/A</option>
            </select>
        </div>
        <div class="form-group"  style="width: 50px">
            <label>&zwnj;</label>
            <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> Pesquisar</button>
        </div>
        <div class="clearfix"></div>
    </form>
    <br />
    <h3>Lista de Pró-Labores</h3>
<table class='table'>
    <thead>
        <tr>
            <th>Empresa</th>
            <th>Nome</th>
            <th>Último pró-labore</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @if($socios->count())
        @foreach($socios as $socio)
        @if($socio->pro_labores()->whereMonth('competencia','=',date('m'))->count() <=0)
        <tr>
            <td>{{$socio->pessoa->nome_fantasia}}</td>
            <td>{{$socio->nome}}</td>
            <td>{{$socio->pro_labores()->orderBy('competencia','desc')->first() ? date_format(date_create($socio->pro_labores()->orderBy('competencia','desc')->first()->competencia.'T00:00:00'), 'm/Y') : 'Não há'}}</td>
            <td><a class='btn btn-primary' href="{{route('cadastrar-pro-labore', ['id' => $socio->id])}}">Cadastrar Pró-Labore</a></td>
        </tr>
        @endif
        @endforeach
        @else
        <tr>
            <td colspan="3">Nenhum registro cadastrado</td>
        </tr>
        @endif
    </tbody>
</table>

    {!! str_replace('/?', '?', $socios->render()) !!}
    <div class="clearfix"></div>
</div>
@stop