@extends('layouts.admin')
@section('header_title', 'Chamados')
@section('main')
<h1>CNAE</h1>
<hr class="dash-title">
<div class="card">
    <h3>Filtros de Pesquisa</h3>
    <form class="form-inline">
        <div class="form-group" style="width: 300px">
            <label>Descrição</label>
            <div class="clearfix"></div>
            <input type="text" class="form-control" name='nome' value='{{Input::get('nome')}}'/>
        </div>
        <div class="form-group" style="width: 300px">
            <label>Código</label>
            <div class="clearfix"></div>
            <input type="text" class="form-control" name='email' value='{{Input::get('email')}}'/>
        </div>
        <div class="form-group" style="width: 250px">
            <label>Ordenar por</label>
            <select name="ordenar" class="form-control">
                <option value="titulo_asc" {{Input::get('ordenar') == 'titulo_asc' ? 'selected' : ''}}>Descrição - A/Z</option>
                <option value="titulo_desc" {{Input::get('ordenar') == 'titulo_desc' ? 'selected' : ''}}>Descrição - Z/A</option>
            </select>
        </div>
        <div class="form-group"  style="width: 50px">
            <label>&zwnj;</label>
            <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> Pesquisar</button>
        </div>
        <div class="clearfix"></div>
    </form>
    <br />
    <h3>Lista de CNAEs</h3>
    <table class='table'>
        <thead>
            <tr>
                <th>Descrição</th>
                <th>Código</th>
                <th>Tabela do simples nacional</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if($cnaes->count())
            @foreach($cnaes as $cnae)
            <tr>
                <td>{{$cnae->descricao}}</td>
                <td>{{$cnae->codigo}}</td>
                <td>{{$cnae->tabela_simples_nacional ? $cnae->tabela_simples_nacional->descricao : null}}</td>
                <td><a href="{{route('editar-cnae', ['id' => $cnae->id])}}" class="btn btn-warning">Editar</a> <a class="btn btn-danger" href="{{$cnae->id}}">Remover</a></td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="2">Nenhum registro cadastrado</td>
            </tr>
            @endif
        </tbody>
        
    </table>
    {!! str_replace('/?', '?', $cnaes->render()) !!}
    <div class="clearfix"></div>
    <a class='btn btn-primary' href='{{route('cadastrar-cnae')}}'>Cadastrar um CNAE</a><br />
    <div class="clearfix"></div>
</div>
@stop