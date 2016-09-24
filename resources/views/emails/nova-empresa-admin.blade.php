@extends('layouts.email')
@section('main')
<div class="col-xs-12">
    <div class="corpo-email">
        <h1>Nova Empresa Cadastrada</h1>
        <hr>
        <p>{{$nome}} cadastrou a empresa {{$empresa->nome_fantasia}} em nosso sistema.</p>
    </div>
    
</div>
@stop