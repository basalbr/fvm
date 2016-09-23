@extends('layouts.dashboard')
@section('header_title', 'Sócio - Histórico')
@section('main')
<h1>Pró-labore <small>{{$socio->nome}}</small></h1>
<hr class="dash-title">
<table class='table'>
    <thead>
        <tr>
            <th>Competência</th>
            <th>Valor do pró-labore</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @if($socio->pro_labores()->count())
        @foreach($socio->pro_labores()->orderBy('competencia','desc')->get() as $pro_labore)
        <tr>
            <td>{{date_format(date_create($pro_labore->competencia.'T00:00:00'),'m/Y')}}</td>
            <td>R$ {{number_format($pro_labore->valor_pro_labore,2,',','.')}}</td>
            <td><a class='btn btn-primary' href="{{route('visualizar-pro-labore-socio', ['id' => $pro_labore->socio->id,'pro_labore'=>$pro_labore->id])}}">Visualizar Pró-Labore</a></td>
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