@extends('layouts.email')
@section('main')
<div class="col-xs-12">
    <div class="corpo-email">
        <h1>Novo usuário cadastrado</h1>
        <hr>
        <p>{{$nome}} se cadastrou no sistema.</p>
        <div class="text-right"><a target="_blank" href="{{route('home')}}"><img src="{{url('images/logotipo-pequeno.png')}}" /></a></div>    
    </div>
    
</div>
@stop