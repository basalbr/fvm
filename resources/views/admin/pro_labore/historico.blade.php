@extends('layouts.admin')
@section('header_title', 'Pró-Labore - Histórico')
@section('main')
<h1>Pró-labore <small>Histórico</small></h1>
<hr class="dash-title">
<table class='table'>
    <thead>
        <tr>
            <th>Competência</th>
            <th>Nome</th>
            <th>Empresa</th>
            <th>Valor do pró-labore</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @if($pro_labores->count())
        @foreach($pro_labores as $pro_labore)
        <tr>
            <td>{{date_format(date_create($pro_labore->competencia.'T00:00:00'),'m/Y')}}</td>
            <td>{{$pro_labore->socio->nome}}</td>
            <td>{{$pro_labore->socio->pessoa->nome_fantasia}}</td>
            <td>R$ {{number_format($pro_labore->valor_pro_labore,2,',','.')}}</td>
            <td><a class='btn btn-primary' href="{{route('editar-pro-labore', ['id' => $pro_labore->socio->id,'pro_labore'=>$pro_labore->id])}}">Editar Pró-Labore</a></td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="3">Nenhum registro cadastrado</td>
        </tr>
        @endif
    </tbody>
</table>

@stop