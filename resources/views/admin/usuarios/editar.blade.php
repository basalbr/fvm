@extends('layouts.admin')
@section('main')
@section('header_title', 'Editar Sócio')



<div class='card'>
    <h1>dados de {{$usuario->nome}}</h1>

    @if($errors->has())
        <div class="alert alert-warning shake">
            <b>Atenção</b><br/>
            @foreach ($errors->all() as $error)
                {{ $error }}<br/>
            @endforeach
        </div>
    @endif
    <h3>Informações</h3>
    <form method="POST" action="">
        <div class="col-xs-12">
            {{ csrf_field() }}
            <div class='form-group'>
                <label>E-mail</label>
                <input type='text' class='form-control' name='email' value="{{$usuario->email}}"/>
            </div>
            <div class='form-group'>
                <label>Nome</label>
                <input type='text' class='form-control' name='nome' value="{{$usuario->nome}}"/>
            </div>
            <div class='form-group'>
                <label>Telefone</label>
                <input type='text' class='form-control fone-mask' name='telefone' value="{{$usuario->telefone}}"/>
            </div>


        </div>
        <div class="clearfix"></div>

        <br/>
    </form>

    @if($usuario->pessoas->count())
        <h3>Empresas</h3>
        <div class="col-xs-12">
            <div class="list-group">
                @foreach($usuario->pessoas as $empresa)

                    <a class="list-group-item"
                       href="{{route('editar-empresa-admin', $empresa->id)}}">
                        <div class="text-primary"><i
                                    class="fa fa-building"></i> {{$empresa->nome_fantasia}} <i
                                    class="fa fa-angle-right"></i></div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <div class="col-xs-12">
        <div class='form-group'>
            <a href="{{URL::previous()}}" class="btn btn-primary"><span class='fa fa-history'></span> Voltar</a>
        </div>
    </div>
    <div class="clearfix"></div>

</div>
@stop