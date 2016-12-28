@extends('layouts.admin')
@section('header_title')
@section('js')
@parent
<script type='text/javascript'>
    var chat_message_last_id;
    var chat_id;
    function getLastId() {
        chat_id = $('#chat_id').val()
        chat_message_last_id = $('#last_id').val();
    }
    ;
    function updateChat() {
        $.post('{{route("atualiza-mensagens-chat")}}', {'chat_id': chat_id, 'chat_message_last_id': chat_message_last_id}, function (data) {
            if (data) {
                var html = '';
                for (i in data) {
                    chat_message_last_id = data[i].id;
                    if (data[i].atendente !== undefined) {
                        html += "<div class='mensagem mensagem-admin'>";
                        html += "<p class='title'>" + data[i].atendente + " - " + data[i].hora + "</p>";
                        html += data[i].mensagem;
                        html += "</div>";
                    } else {
                        html += "<div class='mensagem mensagem-usuario'>";
                        html += "<p class='title'>" + data[i].nome + " - " + data[i].hora + "</p>";
                        html += data[i].mensagem;
                        html += "</div>";
                    }
                }
                $("#mensagens").prepend(html);
            }
        });
    }
    $(function () {
        $('#enviar-mensagem').on('click', function (e) {
            e.preventDefault();
            if (!$('textarea[name="mensagem"]').val()) {
                return false;
            }
            $.post('{{route("envia-mensagem-chat")}}', {id_chat: chat_id, mensagem: $('textarea[name="mensagem"]').val(), id_atendente: $('#id-atendente').val()}, function (data) {

            });
        });
        getLastId();
        setInterval(updateChat, 2000);
    });
</script>
@stop
@section('main')
<div class="card">
    <h1>Visualizar Chat</h1>

    @if($errors->has())
    <div class="alert alert-warning shake">
        <b>Atenção</b><br />
        @foreach ($errors->all() as $error)
        {{ $error }}<br />
        @endforeach
    </div>
    @endif
    <div class="processo-info">
        <h3>Informações</h3>
        <blockquote>
            <div class="pull-left">
                <div class="titulo">Nome</div>
                <div class="info">{{$chat->nome}}</div>
            </div>
            <div class="pull-left">
                <div class="titulo">E-mail</div>
                <div class="info">{{$chat->email}}</div>
            </div>
            <div class="pull-left">
                <div class="titulo">É cadastrado?</div>
                <div class="info">{{$chat->id_usuario ? 'Sim' : 'Não'}}</div>
            </div>
            <div class="clearfix"></div>
        </blockquote>
    </div>
    <h3>Mensagem</h3>

    <form>
        <div class="col-xs-12">
            <div class='form-group'>
                <label>Nova Mensagem</label>
                <textarea class="form-control" name='mensagem' required=""></textarea>
                <input type="hidden" id='id-atendente' value="{{Auth::user()->id}}" />
            </div>
            <div class='form-group'>
                <button type='submit'class='btn btn-success' id='enviar-mensagem'><span class='fa fa-send'></span>  Enviar Mensagem</button>
                <a href="{{URL::previous()}}" class="btn btn-primary"><span class='fa fa-history'></span> Voltar</a>
            </div>
        </div>
    </form>
    <div class="clearfix"></div>
    <br />
    <h3>Últimas mensagens:</h3>
    <div id='mensagens' class="col-xs-12">
        <input type='hidden' value='{{$chat->id}}' id='chat_id' />
        @if(($last_id = $chat->mensagens()->orderBy('updated_at', 'desc')->first(['id'])) instanceof \App\ChatMensagem)
        <input type='hidden' value='{{$last_id->id}}' id='last_id' />

        @else
        <input type='hidden' value='0' id='last_id' />
        @endif
        @foreach($chat->mensagens()->orderBy('updated_at', 'desc')->get() as $mensagem)
        <div class="mensagem {{$mensagem->id_atendente ? 'mensagem-admin':'mensagem-usuario'}}">
            <p class='title'>{{$mensagem->id_atendente ? $mensagem->atendente->nome : $mensagem->chat->nome}} em {{date_format($mensagem->updated_at, 'd/m/Y')}} às {{date_format($mensagem->updated_at, 'H:i')}}</p>
            {{$mensagem->mensagem}}
        </div>
        @endforeach
        <div class="mensagem mensagem-usuario">
            <p class='title'>{{$chat->nome}} em {{date_format($chat->created_at, 'd/m/Y')}} às {{date_format($chat->created_at, 'H:i')}}</p>
            {{$chat->mensagem}}
        </div>
        @stop
    </div>
    <div class="clearfix"></div>
</div>
@stop