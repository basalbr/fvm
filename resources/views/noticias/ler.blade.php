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
<img id="parallax" src="{{url('public/images/banner.jpg')}}"/>
<section id="noticia"> 
    <div class="container bg-white bg-shadow">
        <br />
        <hr>
        <h1 class="title">{{$noticia->titulo}}</h1>
        <hr>
        <img src="{{asset('uploads/noticias/'.$noticia->imagem)}}" style="max-width: 100%"/> 
        <small>Publicado em {{$noticia->created_at->format('d/m/Y')}}</small>
        {!!$noticia->texto!!}
        <div class="clearfix"></div>
        <hr>
        <h2 class="title">Últimas notícias</h2>
        <div class='noticias'>
            @foreach(\App\Noticia::orderBy('created_at','desc')->limit(4)->get() as $k => $noticia)
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
            <a href="{{route('listar-noticias-site')}}" class="btn btn-info">clique para ver mais notícias</a>
        </div>
<br />
    </div>
</section>


@stop