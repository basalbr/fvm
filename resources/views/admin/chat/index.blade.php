@extends('layouts.admin')
@section('main')
<h1>Chats</h1>
<hr class="dash-title">
<br />
<table class='table'>
    <thead>
        <tr>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Última Mensagem</th>
            <th>Enviado em</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @if($chats->count())
        @foreach($chats as $chat)
        <tr>
            <td>{{$chat->nome}}</td>
            <td>{{$chat->email}}</td>
            <td>{{!empty($chat->mensagens()->orderBy('created_at')->first()) ? $chat->mensagens()->orderBy('created_at')->first()->mensagem : $chat->mensagem}}</td>
            <td>{{date_format($chat->created_at, 'd/m/Y - H:i:s')}}</td>
            <td><a href="{{route('visualizar-chat', ['id' => $chat->id])}}" class="btn btn-primary">Visualizar</a></td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="2">Nenhum registro cadastrado</td>
        </tr>
        @endif
    </tbody>
</table>
{!! str_replace('/?', '?', $chats->render()) !!}
<!--@include('pagination.default', ['paginator' => $chats])-->
<div class="clear"></div>

@stop