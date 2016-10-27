@extends('layouts.dashboard')
@section('main')

<h1>Sócios</h1>
<p>Abaixo estão todos os sócios das empresas que você cadastrou.</p>
<hr class="dash-title">
<div class="card">
    <h3>Lista de sócios</h3>
    <table class='table'>
        <thead>
            <tr>
                <th>Empresa</th>
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
                <td>{{$socio->pessoa->nome_fantasia}}</td>
                <td>{{$socio->nome}}</td>
                <td>{{$socio->principal ? 'Sim': 'Não'}}</td>
                <td>{{$socio->pro_labore ? 'R$ '.$socio->pro_labore_formatado(): 'Não retira pró-labore'}}</td>
                <td>
                    <a class="btn btn-warning" href="{{route('editar-socio', [$socio->id_pessoa, $socio->id])}}">Editar</a>
                    @if($socio->pro_labore)
                    <a class="btn btn-primary" href="{{route('listar-pro-labore-socio', [$socio->id])}}">Recibo de Pró-labore</a>
                    @endif
                    @if(!$socio->principal)
                    <a class="btn btn-danger  remover-registro" href="{{route('remover-socio', [$socio->id])}}">Remover</a>
                    @endif
                </td>
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
@stop