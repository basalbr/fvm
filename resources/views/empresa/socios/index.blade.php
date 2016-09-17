@extends('layouts.dashboard')
@section('main')

<h1>Sócios</h1>
<p>Abaixo estão os sócios da empresa <b>{{$empresa}}</b>. Caso deseje cadastrar mais sócios, clique em cadastrar um sócio.</p>
<hr class="dash-title">
<div class="card">
    <table class='table'>
        <thead>
            <tr>
                <th>Nome</th>
                <th>É o sócio responsável?</th>
                <th>Pró-labore</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if($socios->count())
            @foreach($socios as $socio)
            <tr>
                <td>{{$socio->nome}}</td>
                <td>{{$socio->principal ? 'Sim': 'Não'}}</td>
                <td>{{$socio->pro_labore ? 'R$ '.$socio->pro_labore_formatado(): 'Não retira pró-labore'}}</td>
                @if($socio->pro_labore)
                <td><a class="btn btn-warning" href="{{route('editar-socio', [$id_empresa, $socio->id])}}">Editar</a> <a class="btn btn-primary" href="{{route('listar-pro-labore-socio', [$socio->id])}}">Pró-labore</a>  <a class="btn btn-danger" href="{{$socio->id}}">Remover</a></td>
                @else
                <td><a class="btn btn-warning" href="{{route('editar-socio', [$id_empresa, $socio->id])}}">Editar</a> <a class="btn btn-danger" href="{{$socio->id}}">Remover</a></td>
                @endif
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="2">Nenhum registro cadastrado</td>
            </tr>
            @endif
        </tbody>
    </table>
    <a class='btn btn-primary' href='{{route('cadastrar-socio', [$id_empresa])}}'>Cadastrar um sócio</a><br />
</div>
@stop