@extends('layouts.email')
@section('main')
<div class="col-xs-12">
    <div class="corpo-email">
        <h1>Novo contato do site</h1>
        <hr>
        <p><b>Nome:</b> {{$nome}}</p>
        <p><b>Assunto:</b> {{$assunto}}</p>
        <p><b>E-mail:</b> {{$email}}</p>
        <p><b>Mensagem:</b> {{$mensagem}}</p>
    </div>
    
</div>
@stop