@extends('layouts.admin')
@section('header_title', 'Chamados')
@section('main')
    <div class="card">
        <h1>Pró-Labore</h1>

        <h3>Filtros de Pesquisa</h3>
        <form class="form-inline">
            <div class="form-group" style="width: 300px">
                <label>Empresa</label>
                <div class="clearfix"></div>
                <input type="text" class="form-control" name='empresa' value='{{Input::get('empresa')}}'/>
            </div>
            <div class="form-group" style="width: 300px">
                <label>Sócio</label>
                <div class="clearfix"></div>
                <input type="text" class="form-control" name='socio' value='{{Input::get('socio')}}'/>
            </div>
            <div class="form-group" style="width: 250px">
                <label>Ordenar por</label>
                <select name="ordenar" class="form-control">

                    <option value="empresa_asc" {{Input::get('ordenar') == 'empresa_asc' ? 'selected' : ''}}>Empresa -
                        A/Z
                    </option>
                    <option value="empresa_desc" {{Input::get('ordenar') == 'empresa_desc' ? 'selected' : ''}}>Empresa -
                        Z/A
                    </option>
                    <option value="socio_asc" {{Input::get('ordenar') == 'socio_asc' ? 'selected' : ''}}>Sócio - A/Z
                    </option>
                    <option value="socio_desc" {{Input::get('ordenar') == 'socio_desc' ? 'selected' : ''}}>Sócio - Z/A
                    </option>
                </select>
            </div>
            <div class="clearfix"></div>
            <div class="form-group" style="width: 50px">
                <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> Pesquisar</button>
            </div>
            <div class="clearfix"></div>
        </form>
        <br/>
        <h3>Lista de Pró-Labores</h3>
        <table class='table table-striped table-hover'>
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
                    <tr>
                        <td>{{$socio->pessoa->nome_fantasia}}</td>
                        <td>{{$socio->nome}}</td>
                        <td>{{$socio->pro_labores()->orderBy('competencia','desc')->first() ? date_format(date_create($socio->pro_labores()->orderBy('competencia','desc')->first()->competencia.'T00:00:00'), 'm/Y') : 'Não há'}}</td>

                        <td>
                            @if(!$socio->pro_labores()->whereMonth('created_at', '=', date('m'))->count())
                                <a class='btn btn-primary'
                                   href="{{route('cadastrar-pro-labore', ['id' => $socio->id])}}">Cadastrar
                                    Pró-Labore</a>
                            @endif
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

        {!! str_replace('/?', '?', $socios->render()) !!}
        <div class="clearfix"></div>
    </div>
@stop