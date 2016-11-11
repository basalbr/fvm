@extends('layouts.admin')
@section('header_title', 'Chamados')
@section('main')
<h1>Tipos de Tributação</h1>
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
    <h3>Lista de Tipos de Tributação</h3>
    <table class='table'>
        <thead>
            <tr>
                <th>Descrição</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if($tipo_tributacao->count())
            @foreach($tipo_tributacao as $tipo)
            <tr>
                <td>{{$tipo->descricao}}</td>
                <td><a href="{{route('editar-tipo-tributacao', ['id' => $tipo->id])}}" class="btn btn-warning"><span class="fa fa-pencil"></span> Editar</a> <a href="{{$tipo->id}}" class="btn btn-danger"><span class="fa fa-remove"></span> Remover</a></td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="2">Nenhum registro cadastrado</td>
            </tr>
            @endif
        </tbody>
    </table>

    {!! str_replace('/?', '?', $tipo_tributacao->render()) !!}
    <div class="clearfix"></div>
    <a class='btn btn-primary' href='{{route('cadastrar-simples-nacional')}}'>Cadastrar uma tabela do simples nacional</a><br />
    <div class="clearfix"></div>
</div>
@stop