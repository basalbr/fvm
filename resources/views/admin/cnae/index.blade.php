@extends('layouts.admin')
@section('header_title', 'Chamados')
@section('main')

<div class="card">
    <h1>CNAE</h1>
    <h3>Filtros de Pesquisa</h3>
    <form class="form-inline">
        <div class="form-group" style="width: 300px">
            <label>Descrição</label>
            <div class="clearfix"></div>
            <input type="text" class="form-control" name='descricao' value='{{Input::get('descricao')}}'/>
        </div>
        <div class="form-group" style="width: 150px">
            <label>Código</label>
            <div class="clearfix"></div>
            <input type="text" class="form-control cnae-mask" name='codigo' value='{{Input::get('codigo')}}'/>
        </div>
        <div class="form-group" style="width: 150px">
            <label>Tabela</label>
            <div class="clearfix"></div>
            <input type="text" class="form-control" name='tabela' value='{{Input::get('tabela')}}'/>
        </div>
        <div class="form-group" style="width: 150px">
            <label>Ordenar por</label>
            <select name="ordenar" class="form-control">
                <option value="descricao_asc" {{Input::get('ordenar') == 'descricao_asc' ? 'selected' : ''}}>Descrição - A/Z</option>
                <option value="descricao_desc" {{Input::get('ordenar') == 'descricao_desc' ? 'selected' : ''}}>Descrição - Z/A</option>
                <option value="codigo_asc" {{Input::get('ordenar') == 'codigo_asc' ? 'selected' : ''}}>Código - Z/A</option>
                <option value="codigo_desc" {{Input::get('ordenar') == 'codigo_desc' ? 'selected' : ''}}>Código - Z/A</option>
                <option value="tabela_asc" {{Input::get('ordenar') == 'tabela_asc' ? 'selected' : ''}}>Tabela - Z/A</option>
                <option value="tabela_desc" {{Input::get('ordenar') == 'tabela_desc' ? 'selected' : ''}}>Tabela - Z/A</option>
            </select>
        </div>
        <div class="clearfix"></div>
        <div class="form-group"  style="width: 50px">
            <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> Pesquisar</button>
        </div>
        <div class="clearfix"></div>
    </form>
    <br />
    <h3>Lista de CNAEs</h3>
    <table class='table table-hover table-striped'>
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
                <td><a href="{{route('editar-cnae', ['id' => $cnae->id])}}" class="btn btn-warning"><span class="fa fa-edit"></span> Editar</a></td>
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
    <a class='btn btn-primary' href='{{route('cadastrar-cnae')}}'><span class="fa fa-plus"></span> Cadastrar um CNAE</a><br />
    <div class="clearfix"></div>
</div>
@stop