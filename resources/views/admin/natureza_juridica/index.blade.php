@extends('layouts.admin')
@section('header_title', 'Chamados')
@section('main')

<div class="card">
    <h1>Natureza Jurídica</h1>
    <h3>Filtros de Pesquisa</h3>
    <form class="form-inline">
        <div class="form-group" style="width: 300px">
            <label>Descrição</label>
            <div class="clearfix"></div>
            <input type="text" class="form-control" name='descricao' value='{{Input::get('descricao')}}'/>
        </div>
        <div class="form-group" style="width: 300px">
            <label>Representante</label>
            <div class="clearfix"></div>
            <input type="text" class="form-control" name='representante' value='{{Input::get('representante')}}'/>
        </div>
        <div class="form-group" style="width: 250px">
            <label>Ordenar por</label>
            <select name="ordenar" class="form-control">
                <option value="descricao_asc" {{Input::get('ordenar') == 'descricao_asc' ? 'selected' : ''}}>Descrição - A/Z</option>
                <option value="descricao_desc" {{Input::get('ordenar') == 'descricao_desc' ? 'selected' : ''}}>Descrição - Z/A</option>
            </select>
        </div>
        <div class='clearfix'></div>
        <div class="form-group"  style="width: 50px">
            <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> Pesquisar</button>
        </div>
        <div class="clearfix"></div>
    </form>
    <br />
    <h3>Lista de Naturezas Jurídicas</h3>
    <table class='table'>
        <thead>
            <tr>
                <th>Descrição</th>
                <th>Representante</th>
                <th>Qualificação</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if($naturezas_juridicas->count())
            @foreach($naturezas_juridicas as $natureza_juridica)
            <tr>
                <td>{{$natureza_juridica->descricao}}</td>
                <td>{{$natureza_juridica->representante}}</td>
                <td>{{$natureza_juridica->qualificacao}}</td>
                <td><a class="btn btn-warning" href="{{route('editar-natureza-juridica', ['id' => $natureza_juridica->id])}}"><span class='fa fa-edit'></span> Editar</a> <a class="btn btn-danger" href="{{$natureza_juridica->id}}"><span class='fa fa-remove'></span> Remover</a></td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="2">Nenhum registro cadastrado</td>
            </tr>
            @endif
        </tbody>
    </table>


    {!! str_replace('/?', '?', $naturezas_juridicas->render()) !!}
    <div class="clearfix"></div>
    <a class='btn btn-primary' href='{{route('cadastrar-natureza-juridica')}}'><span class='fa fa-plus'></span> Cadastrar</a><br />
    <div class="clearfix"></div>
</div>
@stop