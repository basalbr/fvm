@extends('layouts.admin')
@section('header_title', 'Chamados')
@section('main')
<h1>Pró-labore <small>Pendentes</small></h1>
<hr class="dash-title">
<table class='table'>
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
        @if($socio->pro_labore()->whereMonth('competencia','=',date('m'))->count() <=0)
        <tr>
            <td>{{$socio->pessoa->nome_fantasia}}</td>
            <td>{{$socio->nome}}</td>
            <td>{{$socio->pro_labore()->orderBy('competencia','desc')->first() ? date_format(date_create($socio->pro_labore()->orderBy('competencia','desc')->first()->competencia.'T00:00:00'), 'm/Y') : 'Não há'}}</td>
            <td><a class='btn btn-primary' href="{{route('cadastrar-pro-labore', ['id' => $socio->id])}}">Cadastrar Pró-Labore</a></td>
        </tr>
        @endif
        @endforeach
        @else
        <tr>
            <td colspan="3">Nenhum registro cadastrado</td>
        </tr>
        @endif
    </tbody>
</table>

@stop