@extends('layouts.master')
@section('header_title', 'Home')
@section('content')
<section id='page-header' style="margin-top: 55px" class="page-header">
    <div class='container'>
        <h1>Chamados</h1>
    </div>
</section>
<section>
    <div class="container">
        <table class='table'>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Título</th>
                    <th>Usuário</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @if($chamados->count())
                @foreach($chamados as $chamado)
                <tr>
                    <td>{{$chamado->updated_at}}</td>
                    <td>{{$chamado->titulo}}</td>
                    <td>{{$chamado->usuario->nome}}</td>
                    <td><a href="{{route('visualizar-chamados', ['id' => $chamado->id])}}">Responder</a></td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="2">Nenhum registro cadastrado</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</section>
@stop