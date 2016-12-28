@extends('layouts.admin')
@section('header_title', 'Chamados')
@section('main')
<div class="card">
    <h1>FAQ</h1>

    <h3>Filtros de Pesquisa</h3>
    <form class="form-inline">
        <div class="form-group" style="width: 250px">
            <label>Pergunta</label>
            <div class="clearfix"></div>
            <input type="text" class="form-control" name='pergunta' value='{{Input::get('pergunta')}}'/>
        </div>
        <div class="form-group" style="width: 250px">
            <label>Resposta</label>
            <div class="clearfix"></div>
            <input type="text" class="form-control" name='resposta' value='{{Input::get('resposta')}}'/>
        </div>
        <div class="form-group" style="width: 150px">
            <label>Área do Site</label>
            <select name="local" class="form-control">
                <option value="">Qualquer lugar</option>
                <option value="site" {{Input::get('local') == 'site' ? 'selected' : ''}}>Site</option>
                <option value="dash" {{Input::get('local') == 'dash' ? 'selected' : ''}}>Dashboard</option>
            </select>
        </div>
        <div class="form-group" style="width: 180px">
            <label>Ordenar por</label>
            <select name="ordenar" class="form-control">
                <option value="pergunta_asc" {{Input::get('ordenar') == 'pergunta_asc' ? 'selected' : ''}}>Pergunta - A/Z</option>
                <option value="pergunta_desc" {{Input::get('ordenar') == 'pergunta_desc' ? 'selected' : ''}}>Pergunta - Z/A</option>
                <option value="resposta_asc" {{Input::get('ordenar') == 'resposta_asc' ? 'selected' : ''}}>Resposta - A/Z</option>
                <option value="resposta_desc" {{Input::get('ordenar') == 'resposta_desc' ? 'selected' : ''}}>Resposta - Z/A</option>
                <option value="area_asc" {{Input::get('ordenar') == 'area_asc' ? 'selected' : ''}}>Área do Site - A/Z</option>
                <option value="area_desc" {{Input::get('ordenar') == 'area_desc' ? 'selected' : ''}}>Área do Site - Z/A</option>
            </select>
        </div>
        <div class="clearfix"></div>

        <div class="form-group"  style="width: 50px">
            <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> Pesquisar</button>
        </div>
        <div class="clearfix"></div>
    </form>
    <br />
    <h3>Lista de FAQs</h3>
    <div class="table-responsive">
        <table class='table table-striped table-hover'>
            <thead>
                <tr>
                    <th>Área do Site</th>
                    <th>Pergunta</th>
                    <th>Resposta</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @if($faqs->count())
                @foreach($faqs as $faq)
                <tr>
                    <td><b>{{ucwords($faq->local)}}</b></td>
                    <td>{!!str_limit($faq->pergunta,50)!!}</td>
                    <td>{!!str_limit($faq->resposta,50)!!}</td>
                    <td style="width: 200px;"><a class="btn btn-warning" href="{{route('editar-faq', ['id' => $faq->id])}}"><span class="fa fa-edit"></span> Editar</a> <a class="btn btn-danger" href="{{$faq->id}}"><span class="fa fa-remove"></span> Remover</a></td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="4">Nenhum registro cadastrado</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
    {!! str_replace('/?', '?', $faqs->render()) !!}
    <div class="clearfix"></div>
    <a class='btn btn-primary' href='{{route('cadastrar-faq')}}'><span class="fa fa-plus"></span> Cadastrar um f.a.q</a><br />
    <div class="clearfix"></div>
</div>
@stop