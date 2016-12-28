@extends('layouts.admin')
@section('header_title', 'Mensalidades')
@section('main')

<div class="card">
    <h1>Mensalidades</h1>
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
    <h3>Lista de Mensalidades</h3>
    @if($mensalidades->count())

    <div class="item-list">
        @foreach($mensalidades as $mensalidade)
        <div class="item">
            <div class="item-content">
                <div class="item-content-header">Nome Fantasia</div>
                <div class="item-content-description"><a href="{{route('editar-empresa-admin', [$mensalidade->empresa->id])}}">{{$mensalidade->empresa->nome_fantasia}}</a></div>
            </div>
            <div class="item-content">
                <div class="item-content-header">Razão Social</div>
                <div class="item-content-description"><a href="{{route('editar-empresa-admin', [$mensalidade->empresa->id])}}">{{$mensalidade->empresa->razao_social}}</a></div>
            </div>
            <div class="item-content">
                <div class="item-content-header">Usuário</div>
                <div class="item-content-description">{{$mensalidade->empresa->usuario->nome}}</div>
            </div>
            <div class="clearfix"></div>
            <div class="item-content">
                <div class="item-content-header">Documentos Fiscais</div>
                <div class="item-content-description">{{$mensalidade->documentos_fiscais}}</div>
            </div>
            <div class="item-content">
                <div class="item-content-header">Documentos Contábeis</div>
                <div class="item-content-description">{{$mensalidade->documentos_contabeis}}</div>
            </div>
            <div class="item-content">
                <div class="item-content-header">Funcionários</div>
                <div class="item-content-description">{{$mensalidade->funcionarios}}</div>
            </div>
            <div class="item-content">
                <div class="item-content-header">Pró-labores</div>
                <div class="item-content-description">{{$mensalidade->pro_labores}}</div>
            </div>
            <div class="clearfix"></div>
            <div class="item-content">
                <div class="item-content-header">Valor</div>
                <div class="item-content-description">{{$mensalidade->valor_formatado()}}</div>
            </div>
            <div class="item-content">
                <div class="item-content-header">Último Pagamento</div>
                <div class="item-content-description">&zwnj;{{$mensalidade->ultimo_pagamento()}}</div>
            </div>
            <div class="item-content">
                <div class="item-content-header">Próximo Pagamento</div>
                <div class="item-content-description">{{$mensalidade->proximo_pagamento('d/m/Y')}}</div>
            </div>
            <div class="clearfix"></div>
        </div>
        @endforeach
    </div>

    {!! str_replace('/?', '?', $mensalidades->render()) !!}
    <div class="clearfix"></div>

    @endif
</div>

@stop