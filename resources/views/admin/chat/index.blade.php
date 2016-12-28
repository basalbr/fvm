@extends('layouts.admin')
@section('header_title', 'Chamados')
@section('js')
@parent
<script type="text/javascript" src="{{url('public/js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript" src="{{url('public/js/bootstrap-datepicker.pt-BR.min.js')}}"></script>
<script type="text/javascript" language="javascript">
$(function () {
    $('.date-mask').on('keypress', function () {
        return false;
    });
    $('.date-mask').datepicker({
        language: 'pt-BR',
        autoclose: true,
        format: 'dd/mm/yyyy',
        todayBtn: 'linked'
    });
});
</script>
@stop
@section('main')

<div class="card">
    <h1>Chat</h1>
    <h3>Filtros de Pesquisa</h3>
    <form class="form-inline">
        <div class="form-group" style="width: 180px">
            <label>Nome</label>
            <div class="clearfix"></div>
            <input type="text" class="form-control" name='nome' value='{{Input::get('nome')}}'/>
        </div>
        <div class="form-group" style="width: 180px">
            <label>E-mail</label>
            <div class="clearfix"></div>
            <input type="text" class="form-control" name='email' value='{{Input::get('email')}}'/>
        </div>
        <div class="form-group" style="width: 110px">
            <label>De</label>
            <input type="text" class="form-control date-mask" name='de' value='{{Input::get('de')}}'/>
        </div>
        <div class="form-group" style="width: 110px">
            <label>Até</label>
            <input type="text" class="form-control date-mask" name='ate' value='{{Input::get('ate')}}'/>
        </div>
        <div class="form-group" style="width: 200px">
            <label>Ordenar por</label>
            <select name="ordenar" class="form-control">
                <option value="atualizado_desc" {{Input::get('ordenar') == 'atualizado_desc' ? 'selected' : ''}}>Mais recente</option>
                <option value="atualizado_asc" {{Input::get('ordenar') == 'atualizado_asc' ? 'selected' : ''}}>Mais antigo</option>
                <option value="nome_asc" {{Input::get('ordenar') == 'nome_asc' ? 'selected' : ''}}>Nome - A/Z</option>
                <option value="nome_desc" {{Input::get('ordenar') == 'nome_desc' ? 'selected' : ''}}>Nome - Z/A</option>
                <option value="email_asc" {{Input::get('ordenar') == 'email_asc' ? 'selected' : ''}}>E-mail - A/Z</option>
                <option value="email_desc" {{Input::get('ordenar') == 'email_desc' ? 'selected' : ''}}>E-mail - Z/A</option>
            </select>
        </div>
        <div class="clearfix"></div>
        <div class="form-group"  style="width: 50px">
            <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> Pesquisar</button>
        </div>
        <div class="clearfix"></div>
    </form>
    <br />
    <h3>Lista de chats</h3>
    
    @if($chats->count())
    <div class="item-list">
        @foreach($chats as $chat)
        <div class="item">
            <div class="item-content">
                <div class="item-content-header">Nome</div>
                <div class="item-content-description">{{$chat->nome}}</div>
            </div>
            <div class="item-content">
                <div class="item-content-header">E-mail</div>
                <div class="item-content-description">{{$chat->email}}</div>
            </div>

            
            <div class="item-content">
                <div class="item-content-header">Mensagem</div>
                <div class="item-content-description">{{!empty($chat->mensagens()->orderBy('created_at')->first()) ? str_limit($chat->mensagens()->orderBy('created_at')->first()->mensagem, 50) : str_limit($chat->mensagem,50)}}</div>
            </div>
            <div class="item-content">
                <div class="item-content-header">Enviado em</div>
                <div class="item-content-description">{{date_format($chat->updated_at, 'd/m/Y - H:i:s')}}</div>
            </div>
            <div class="clearfix"></div>
            <div class="item-content">
               <div class="item-content-header">Opções</div>
                <div class="item-content-description"><a href="{{route('visualizar-chat', ['id' => $chat->id])}}" class="btn btn-primary"><span class="fa fa-search"></span> Visualizar</a>
                <a href="{{route('visualizar-chat', ['id' => $chat->id])}}" class="btn btn-danger"><span class="fa fa-remove"></span> Remover</a></div>
            </div>
            <div class="clearfix"></div>
        </div>
        @endforeach
    </div>
    {!! str_replace('/?', '?', $chats->render()) !!}
    <div class="clearfix"></div>
    @endif
</div>
@stop