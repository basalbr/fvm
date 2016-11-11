@extends('layouts.admin')
@section('header_title', 'Chamados')
@section('main')
<h1>FAQ</h1>
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
                <td><a class="btn btn-warning" href="{{route('editar-natureza-juridica', ['id' => $natureza_juridica->id])}}">Editar</a> <a class="btn btn-danger" href="{{$natureza_juridica->id}}">Remover</a></td>
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
    <a class='btn btn-primary' href='{{route('cadastrar-natureza-juridica')}}'>Cadastrar uma natureza jurídica</a><br />
    <div class="clearfix"></div>
</div>
@stop