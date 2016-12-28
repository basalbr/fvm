@extends('layouts.admin')
@section('header_title', 'Chamados')
@section('main')

<div class="card">
    <h1>Impostos</h1>
    <h3>Filtros de Pesquisa</h3>
    <form class="form-inline">
        <div class="form-group" style="width: 300px">
            <label>Nome</label>
            <div class="clearfix"></div>
            <input type="text" class="form-control" name='pergunta' value='{{Input::get('pergunta')}}'/>
        </div>
        <div class="form-group" style="width: 150px">
            <label>Ordenar por</label>
            <select name="ordenar" class="form-control">
                <option value="nome_asc" {{Input::get('ordenar') == 'nome_asc' ? 'selected' : ''}}>Nome - A/Z</option>
                <option value="nome_desc" {{Input::get('ordenar') == 'nome_desc' ? 'selected' : ''}}>Nome - Z/A</option>
            </select>
        </div>
        <div class="clearfix"></div>
        <div class="form-group"  style="width: 50px">
            <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> Pesquisar</button>
        </div>
        <div class="clearfix"></div>
    </form>
    <br />
    <h3>Lista de Impostos</h3>
    <table class='table table-hover table-striped'>
        <thead>
            <tr>
                <th>Nome</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if($impostos->count())
            @foreach($impostos as $imposto)
            <tr>
                <td>{{$imposto->nome}}</td>
                <td>
                    <a class="btn btn-info" href="{{route('listar-instrucao', ['id' => $imposto->id])}}"><span class="fa fa-magic"></span> Instruções</a>
                    <a class="btn btn-primary" href="{{route('listar-informacao-extra', ['id' => $imposto->id])}}"><span class="fa fa-paperclip"></span> Informações Extras</a>
                    <a class="btn btn-warning" href="{{route('editar-imposto', ['id' => $imposto->id])}}"><span class="fa fa-edit"></span> Editar</a>
                    <a class="btn btn-danger" href="{{$imposto->id}}"><span class="fa fa-remove"></span> Remover</a>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="2">Nenhum registro cadastrado</td>
            </tr>
            @endif
        </tbody>
    </table>

    {!! str_replace('/?', '?', $impostos->render()) !!}
    <div class="clearfix"></div>
    <a class='btn btn-primary' href='{{route('cadastrar-imposto')}}'><span class="fa fa-plus"></span> Cadastrar um imposto</a><br />
    <div class="clearfix"></div>
</div>
@stop