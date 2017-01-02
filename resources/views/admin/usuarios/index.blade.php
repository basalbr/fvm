@extends('layouts.admin')
@section('header_title', 'Empresas')
@section('main')

<div class="card">
    <h1>Usuários</h1>
    <h3>Filtros de Pesquisa</h3>
    <form class="form-inline">
        <div class="form-group" style="width: 160px">
            <label>Nome</label>
            <div class="clearfix"></div>
            <input type="text" class="form-control" name='nome' value='{{Input::get('nome')}}'/>
        </div>
        <div class="form-group" style="width: 160px">
            <label>E-mail</label>
            <div class="clearfix"></div>
            <input type="text" class="form-control" name='email' value='{{Input::get('email')}}'/>
        </div>
        <div class="form-group" style="width: 200px">
            <label>Ordenar por</label>
            <select name="ordenar" class="form-control">
                <option value="nome_asc" {{Input::get('ordenar') == 'nome_asc' ||  !Input::get('ordenar') ? 'selected' : ''}}>Nome - A/Z</option>
                <option value="nome_desc" {{Input::get('ordenar') == 'nome_desc' ? 'selected' : ''}}>Nome - Z/A</option>
                <option value="email_asc" {{Input::get('ordenar') == 'email_asc' ? 'selected' : ''}}>E-mail - A/Z</option>
                <option value="email_desc" {{Input::get('ordenar') == 'email_desc' ? 'selected' : ''}}>E-mail - Z/A</option>
                <option value="cadastrado_asc" {{Input::get('ordenar') == 'cadastrado_asc' ? 'selected' : ''}}>Mais novo</option>
                <option value="cadastrado_desc" {{Input::get('ordenar') == 'cadastrado_desc' ? 'selected' : ''}}>Mais antigo</option>
            </select>
        </div>
        <div class="clearfix"></div>
        <div class="form-group"  style="width: 50px">
            <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> Pesquisar</button>
        </div>
        <div class="clearfix"></div>
    </form>
    <br />
    <h3>Lista de usuarios</h3>
    <table class='table table-hover table-striped'>
        <thead>
            <tr>

                <th>Nome</th>
                <th>E-mail</th>
                <th>Telefone</th>
                <th>Cadastrado em</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if($usuarios->count())
            @foreach($usuarios as $usuario)
            <tr>

                <td>{{$usuario->nome}}</td>
                <td>{{$usuario->email}}</td>
                <td>{{$usuario->telefone}}</td>
                <td>{{$usuario->created_at->format('d/m/Y')}}</td>
                <td>
                    <a class='btn btn-primary' href="{{route('visualizar-usuario-admin', ['id' => $usuario->id])}}"><span class='fa fa-search'></span> Visualizar</a>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="3">Nenhum registro cadastrado</td>
            </tr>
            @endif
        </tbody>
    </table>
    {!! str_replace('/?', '?', $usuarios->render()) !!}
    <div class="clearfix"></div>
</div>
@stop
