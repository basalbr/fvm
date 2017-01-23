@extends('layouts.admin')
@section('header_title', $alteracao->tipo->descricao)
@section('main')

<div class="card">
    <h1>{{$alteracao->tipo->descricao}}</h1>
    @if($errors->has())
    <div class="alert alert-warning shake">
        <b>Atenção</b><br />
        @foreach ($errors->all() as $error)
        {{ $error }}<br />
        @endforeach
    </div>
    @endif
    <h3>Informações</h3>
    <div class="processo-info">
        <blockquote>
            <h4>Informações da Solicitação</h4>

            <div class="pull-left">
                <div class="titulo">Tipo</div>
                <div class="info">{{$alteracao->tipo->descricao}}</div>
            </div>
            <div class="pull-left">
                <div class="titulo">Status da Solicitação</div>
                <div class='text-success info'>{{$alteracao->status}}</div>
            </div>
            <div class="pull-left">
                <div class="titulo">Status do Pagamento</div>
                <div class='text-success info'>{{$alteracao->pagamento->status}}</div>
            </div>
            <div class='clearfix'></div>
            @foreach($alteracao->informacoes as $informacao)
            <div class="pull-left">
                <div class="titulo">{{$informacao->campo->nome}}</div>
                @if($informacao->campo->tipo == 'file')
                <div class="info"><a download href='{{asset('/uploads/alteracao/'.$informacao->valor)}}' target="_blank">Download</a></div>
                @else
                <div class="info">{{$informacao->valor}}</div>
                @endif
            </div>
            @endforeach
            <div class="clearfix"></div>
            <h4>Informações da empresa</h4>
            <div class="pull-left">
                <div class="titulo">Nome Fantasia</div>
                <div class="info"><a href="{{route('editar-empresa-admin',[$alteracao->empresa->id])}}">{{$alteracao->empresa->nome_fantasia}}</a></div>
            </div>
            <div class="pull-left">
                <div class="titulo">Razão Social</div>
                <div class="info"><a href="{{route('editar-empresa-admin',[$alteracao->empresa->id])}}">{{$alteracao->empresa->razao_social}}</a></div>
            </div>
            <div class="pull-left">
                <div class="titulo">CNPJ</div>
                <div class="info">{{$alteracao->empresa->cpf_cnpj}}</div>
            </div>
            <div class="clearfix"></div>
        </blockquote>
    </div>
    <br />
    <h3>Enviar Mensagem</h3>
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="col-md-12">
            {{ csrf_field() }}
            <div class='form-group'>
                <label>Status</label>
                <select class='form-control' name='status'>
                    <option {{$alteracao->status == 'Pendente' ? 'selected' : ''}} value="Pendente">Pendente</option>
                    <option {{$alteracao->status == 'Concluído' ? 'selected' : ''}} value="Concluído">Concluído</option>
                </select>
            </div>
            <div class='form-group'>
                <label>Anexar arquivo</label>
                <input type='file' class='form-control' value="" name='anexo'/>
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

    @if($alteracao->mensagens->count())
    @foreach($alteracao->mensagens()->orderBy('updated_at', 'desc')->get() as $mensagem)
    <div class='form-group'>
        <div class="col-md-12">
            <div class="mensagem {{$mensagem->usuario->id == Auth::user()->id ? 'mensagem-usuario':'mensagem-admin'}}">
                <p class='title'>{{$mensagem->usuario->nome}} em {{$mensagem->updated_at->format('d/m/Y')}} às {{$mensagem->updated_at->format('H:i')}}</p>
                {{$mensagem->mensagem}}
                @if($mensagem->anexo)
                <div class="anexo"><span class="fa fa-file-o"></span> <a download href='{{asset('/uploads/alteracao/'.$mensagem->anexo)}}' target="_blank">Anexo</a></div>
                @endif
            </div>
        </div>
    </div>
    @endforeach
    @else
    <div class='col-xs-12'>
        <p>Nenhuma mensagem encontrada</p>
    </div>

    @endif

    <div class="clearfix"></div>
</div>
@stop