@extends('layouts.admin')
@section('header_title', 'Chamados')
@section('main')

<div class="card">
    <h1>Chamado {{$chamado->titulo}}</h1>
    <h3>Mensagem</h3>
    @if($errors->has())
    <div class="alert alert-warning shake">
        <b>Atenção</b><br />
        @foreach ($errors->all() as $error)
        {{ $error }}<br />
        @endforeach
    </div>
    @endif

    <form method="POST" action="" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="col-xs-12">
            <div class='form-group'>
                <label>Status</label>
                <select class='form-control' name='status'>
                    <option {{$chamado->status == 'Aberto' ? 'selected' : ''}} value="Aberto">Aberto</option>
                    <option {{$chamado->status == 'Concluído' ? 'selected' : ''}} value="Concluído">Concluído</option>
                </select>
            </div>
            <div class='form-group'>
                <label>Anexar arquivo</label>
                <input type='file' class='form-control' value="" name='arquivo'/>
            </div>
            <div class='form-group'>
                <label>Nova Mensagem</label>
                <textarea class="form-control" name='mensagem'></textarea>
            </div>
            <div class='form-group'>
                <button type='submit'class='btn btn-success'><span class='fa fa-send'></span>  Enviar Mensagem</button>
                <a href="{{URL::previous()}}" class="btn btn-primary"><span class='fa fa-history'></span> Voltar</a>
            </div>
        </div>
    </form>
    <div class="clearfix"></div>
    <br />
    <h3>Últimas mensagens:</h3>
    @if($chamado->chamado_respostas->count())
    @foreach($chamado->chamado_respostas()->orderBy('updated_at', 'desc')->get() as $resposta)
    <div class='form-group'>
        <div class="mensagem {{$resposta->usuario->admin ? 'mensagem-admin':'mensagem-usuario'}}">
            <p class='title'>{{$resposta->usuario->nome}} em {{$resposta->updated_at->format('d/m/Y')}} às {{$resposta->updated_at->format('H:i')}}</p>
            {{$resposta->mensagem}}
            @if($resposta->anexo)
            <div class="anexo"><span class="fa fa-file-o"></span> <a download href='{{asset('/uploads/chamados/'.$resposta->anexo)}}' target="_blank">Anexo</a></div>
            @endif
        </div>
    </div>
    @endforeach
    @else
    <p>Nenhuma mensagem encontrada</p>
    @endif
    <div class="clearfix"></div>
</div>
@stop