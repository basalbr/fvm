@extends('layouts.admin')
@section('header_title', 'Empresas')
@section('main')

<div class="card">
    <h1>Empresas</h1>
    <h3>Filtros de Pesquisa</h3>
    <form class="form-inline">
        <div class="form-group" style="width: 160px">
            <label>Nome Fantasia</label>
            <div class="clearfix"></div>
            <input type="text" class="form-control" name='nome_fantasia' value='{{Input::get('nome_fantasia')}}'/>
        </div>
        <div class="form-group" style="width: 160px">
            <label>Razão Social</label>
            <div class="clearfix"></div>
            <input type="text" class="form-control" name='razao_social' value='{{Input::get('razao_social')}}'/>
        </div>
        <div class="form-group" style="width: 150px">
            <label>CNPJ</label>
            <div class="clearfix"></div>
            <input type="text" class="form-control cnpj-mask" name='cnpj' value='{{Input::get('cnpj')}}'/>
        </div>
        <div class="form-group" style="width: 180px">
            <label>Usuário</label>
            <div class="clearfix"></div>
            <input type="text" class="form-control" name='usuario' value='{{Input::get('usuario')}}'/>
        </div>
        <div class="form-group" style="width: 200px">
            <label>Ordenar por</label>
            <select name="ordenar" class="form-control">
                <option value="nome_fantasia_asc" {{Input::get('ordenar') == 'nome_preferencial_asc' ||  !Input::get('ordenar') ? 'selected' : ''}}>Nome Fantasia - A/Z</option>
                <option value="nome_fantasia_desc" {{Input::get('ordenar') == 'nome_preferencial_desc' ? 'selected' : ''}}>Nome Fantasia - Z/A</option>
                <option value="usuario_asc" {{Input::get('ordenar') == 'usuario_asc' ? 'selected' : ''}}>Usuário - A/Z</option>
                <option value="usuario_desc" {{Input::get('ordenar') == 'usuario_desc' ? 'selected' : ''}}>Usuário - Z/A</option>
                <option value="razao_social_asc" {{Input::get('ordenar') == 'nome_preferencial_asc' ? 'selected' : ''}}>Razão Social - A/Z</option>
                <option value="razao_social_desc" {{Input::get('ordenar') == 'nome_preferencial_desc' ? 'selected' : ''}}>Razão Social - Z/A</option>
            </select>
        </div>
        <div class="clearfix"></div>
        <div class="form-group"  style="width: 50px">
            <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> Pesquisar</button>
        </div>
        <div class="clearfix"></div>
    </form>
    <br />
    <h3>Lista de empresas</h3>
    <table class='table table-hover table-striped'>
        <thead>
            <tr>

                <th>Nome Fantasia</th>
                <th>Razão Social</th>
                <th>CNPJ</th>
                <th>Usuário</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if($empresas->count())
            @foreach($empresas as $empresa)
            <tr>

                <td>{{$empresa->nome_fantasia}}</td>
                <td>{{$empresa->razao_social}}</td>
                <td>{{$empresa->cpf_cnpj}}</td>
                <td>{{$empresa->usuario->nome}}</td>
                <td>
                    @if($empresa->status != 'Aprovado')
                    <a class='btn btn-success' href="{{route('ativar-empresa-admin', ['id' => $empresa->id])}}">Ativar Empresa</a>
                    @endif
                    <a class='btn btn-primary' href="{{route('editar-empresa-admin', ['id' => $empresa->id])}}"><span class='fa fa-search'></span> Visualizar</a>
                    <a class='btn btn-danger' href="{{route('remover-empresa-admin', ['id' => $empresa->id])}}"><span class='fa fa-remove'></span> Remover</a>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="6">Nenhum registro cadastrado</td>
            </tr>
            @endif
        </tbody>
    </table>
    {!! str_replace('/?', '?', $empresas->render()) !!}
    <div class="clearfix"></div>
</div>
@stop
