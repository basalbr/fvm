@extends('layouts.master')
@section('js')
@parent
<script type="text/javascript">
    var chat;
    function notify(title, message, url) {
        if (Notification.permission !== "granted")
            Notification.requestPermission();
        else {
            var notification = new Notification(title, {
                icon: 'http://webcontabilidade.com/images/notificacao.png',
                body: message,
            });

            notification.onclick = function () {
                window.open(url);
            };

        }

    }
    function inicializaChatNotifications() {
        $.get("{{route('ajax-chat-count')}}", function (data) {
            chat = data;
            setInterval(function () {
                $.get("{{route('ajax-chat-notification')}}", function (data) {
                    if (data.total != chat) {
                        chat = data.total;
                        notify(data.title, data.message, data.url);
                    }
                });
            }, 5000);
        });

    }

    function askPermission() {
        if (Notification.permission !== "granted") {
            Notification.requestPermission();
        }
    }

    $(function () {
        inicializaChatNotifications();
        askPermission();
    });
</script>
@stop
@section('content')
<div id="sidebar-left">
    <ul>
        <li class='{{Route::is('admin') ? "active" : ""}}'>
            <a href="{{route('admin')}}"><div class="icon"><span class="fa fa-home"></span></div>Início</a>
        </li>
        <li class='{{Request::is('admin/abertura-empresa*') ? "active" : ""}}'>
            <a href="{{route('abertura-empresa-admin')}}"><div class="icon"><span class="fa fa-child"></div>Abertura de Empresas</a>
        </li>
        <li class='{{Request::is('admin/empresas*') ? "active" : ""}}'>
            <a href="{{route('empresas-admin')}}"><div class="icon"><span class="fa fa-building"></div>Empresas</a>
        </li>
        <li class='{{Request::is('admin/mensalidades*') ? "active" : ""}}'>
            <a href="{{route('listar-mensalidades-admin')}}"><div class="icon"><span class="fa fa-book"></span></div>mensalidades ativas</a>
        </li>
        <li class='{{Request::is('admin/chamados*') ? "active" : ""}}'>
            <a href="{{route('listar-chamados')}}"><div class="icon"><span class="fa fa-envelope"></span></div>Chamados</a>
        </li>
        <li class='{{Request::is('admin/chat*') ? "active" : ""}}'>
            <a href="{{route('listar-chat')}}"><div class="icon"><span class="fa fa-comment"></span></div>Chat</a>
        </li>
        <li class='{{Request::is('admin/cnae*') ? "active" : ""}}'>
            <a href="{{route('listar-cnae')}}"><div class="icon"><span class="fa fa-industry"></span></div>CNAEs</a>
        </li>
        <li class='{{Request::is('admin/faq*') ? "active" : ""}}'>
            <a href="{{route('listar-faq')}}"><div class="icon"><span class="fa fa-info"></span></div>F.A.Q</a>
        </li>
        <li class='{{Request::is('admin/imposto*') ? "active" : ""}}'>
            <a href="{{route('listar-imposto')}}"><div class="icon"><span class="fa fa-money"></span></div>Impostos</a>
        </li>
        <li class='{{Request::is('admin/natureza-juridica*') ? "active" : ""}}'>
            <a href="{{route('listar-natureza-juridica')}}"><div class="icon"><span class="fa fa-legal"></span></div>Nat. Jurídica</a>
        </li>
        <li class='{{Request::is('admin/plano*') ? "active" : ""}}'>
            <a href="{{route('listar-plano')}}"><div class="icon"><span class="fa fa-shopping-cart"></span></div>Planos</a>
        </li>
        <li class='{{Request::is('admin/apuracoes*') ? "active" : ""}}'>
            <a href="{{route('listar-processos-admin')}}"><div class="icon"><span class="fa fa-file"></span></div>apurações</a>
        </li>
        <li class='{{Request::is('admin/pro-labore*') ? "active" : ""}}'>
            <a href="{{route('listar-pro-labore')}}"><div class="icon"><span class="fa fa-dollar"></span></div>pró-labore</a>
        </li>
        <li class='{{Request::is('admin/simples-nacional*') ? "active" : ""}}'>
            <a href="{{route('listar-simples-nacional')}}"><div class="icon"><span class="fa fa-table"></span></div>Simples Nacional</a>
        </li>
        <li class='{{Request::is('admin/tipo-tributacao*') ? "active" : ""}}'>
            <a href="{{route('listar-tipo-tributacao')}}"><div class="icon"><span class="fa fa-sitemap"></span></div>Tip. Tributação</a>
        </li>
        <li class='{{Request::is('admin/noticias*') ? "active" : ""}}'>
            <a href="{{route('listar-noticias')}}"><div class="icon"><span class="fa fa-newspaper-o"></span></div>Notícias</a>
        </li>
    </ul>
</div>
<div id="dash-container" class='bg-ltblue'>
    <div class="container-fluid">
        @yield('main')
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
</div>
<div>
    @yield('modal')
</div>
@overwrite