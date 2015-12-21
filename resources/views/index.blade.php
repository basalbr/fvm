@extends('layouts.master')
@section('header_title', 'Home')
@section('content')
<section id="header" style="height: 600px; overflow: hidden; position: relative; text-align: center">
    <h1 class="text-uppercase">F.V.M</h1>
    <h2 class="text-uppercase">faça você mesmo</h2>
    <a class="btn btn-default text-uppercase">Clique para conhecer</a>
    <a class="btn btn-default text-uppercase" href='{{route('acessar')}}'>clique para acessar</a>
    <img src="{{url('public/images/banner.jpg')}}"/>
</section>
<section>
    <div class="container"></div>
</section>
@stop