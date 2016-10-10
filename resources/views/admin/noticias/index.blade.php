@extends('layouts.admin')
@section('main')
<h1>Notícias</h1>
<hr class="dash-title">

    <table class='table'>
        <thead>
            <tr>
                <th>Data</th>
                <th>Título</th>
                <th>Resumo</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if($noticias->count())
            @foreach($noticias as $noticia)
            <tr>
                <td>{{$noticia->created_at->format('d/m/Y')}}</td>
                <td>{{$noticia->titulo}}</td>
                <td>{!!str_limit($noticia->texto, 50)!!}</td>
                <td><a class="btn btn-warning" href="{{route('editar-noticia', ['id_noticia' =>$noticia->id])}}">Editar</a> <a class="btn btn-danger" href="{{$noticia->id}}">Remover</a></td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="4">Nenhum registro cadastrado</td>
            </tr>
            @endif
        </tbody>
    </table>
    <a class='btn btn-primary' href='{{route('cadastrar-noticia')}}'>Cadastrar uma notícia</a><br />

    @stop