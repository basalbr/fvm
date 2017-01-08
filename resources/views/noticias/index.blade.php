@extends('layouts.master')
@section('header_title', 'Home')
@section('js')
@parent
<script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-84798442-1', 'auto');
    ga('send', 'pageview');

</script>
@stop
@section('content')
<img id="parallax" src="{{url(public_path().'images/banner.jpg')}}"/>
<section id="noticias" class="">
    <div class="container bg-white bg-shadow">
        <br />
        <hr>
        <h1 class="title">Notícias</h1>
        <hr>
        <div class='noticias col-xs-12'>
            @foreach($noticias as $k => $noticia)
            <div class="noticia">
                <a href="{{route('ler-noticia',[$noticia->id, str_slug($noticia->titulo)])}}">
                    <img src="{{ asset('uploads/noticias/thumb/'.$noticia->imagem) }}" />
                    <div class="titulo">{{$noticia->titulo}}</div>
                    <div class="data">{{date_format($noticia->created_at, 'd/m/Y')}}</div>
                </a>
            </div>
            @endforeach
            <div class="clearfix"></div>
            <br />
        </div>
        <div class="text-center">
        <a href="{{route('home')}}" class="btn btn-success">Voltar para página inicial</a>
        </div>
        <div class="clearfix"></div>
        <br />
    </div>
</section>


@stop