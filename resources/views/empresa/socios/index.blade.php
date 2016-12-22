@extends('layouts.dashboard')
@section('main')


<div class="card">
    <h1>Sócios</h1>
    <p>Abaixo estão os sócios da empresa <b>{{$empresa}}</b>. Caso deseje cadastrar mais sócios, clique em cadastrar um sócio.</p>
    <h3>Lista de sócios de {{\App\Pessoa::find($id_empresa)->nome_fantasia}}</h3>
    <table class='table table-hover table-striped'>
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
                <td>
                    <a class="btn btn-warning" href="{{route('editar-socio', [$id_empresa, $socio->id])}}"><span class="fa fa-edit"></span> Editar</a>
                    @if($socio->pro_labore)
                    <a class="btn btn-primary" href="{{route('listar-pro-labore-socio', [$socio->id])}}"><span class="fa fa-sticky-note-o"></span> Recibo de Pró-labore</a>
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
    <a class='btn btn-success' href='{{route('cadastrar-socio', [$id_empresa])}}'><span class="fa fa-plus"></span> Cadastrar um sócio</a>
    <a href="{{URL::previous()}}" class="btn btn-primary"><span class='fa fa-history'></span> Voltar</a>
    
</div>
@stop