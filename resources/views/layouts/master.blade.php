<!DOCTYPE html>
<html>
    <head>
        <title>WEBContabilidade - @yield('header_title')</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @section('css')
        <link href='https://fonts.googleapis.com/css?family=Raleway:400,700,700italic,400italic' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="{{url('public/css/font-awesome.min.css')}}" />
        <link rel="stylesheet" type="text/css" href="{{url('public/css/bootstrap.min.css')}}" />
        <link rel="stylesheet" name="text/css" href="{{url('public/css/fullcalendar.min.css')}}" />
        <link rel="stylesheet" type="text/css" href="{{url('public/css/bootstrap-datepicker3.min.css')}}" />
        <link rel="stylesheet" type="text/css" href="{{url('public/css/animate.css')}}" />
        <link rel="stylesheet" type="text/css" href="{{url('public/css/custom.css')}}" />
        @show
        @section('js')

        <script type="text/javascript" src="{{url('public/js/jquery-2.1.4.min.js')}}"></script>
        <script type="text/javascript" src="{{url('public/js/moment.min.js')}}"></script>
        <script type="text/javascript" src="{{url('public/js/bootstrap.min.js')}}"></script>
        <script type="text/javascript" src="{{url('public/js/mask.js')}}"></script>
        <script name="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.6.1/fullcalendar.min.js"></script>
        <script type="text/javascript" src="{{url('public/js/pt-br.js')}}"></script>
        <script type="text/javascript"  language="javascript">
$(function () {

    $('a.page-scroll').bind('click', function (event) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top - 50
        }, 1000, 'easeInOutExpo');
        event.preventDefault();
    });

    $("#instrucao").on('click', '.btn-instrucao-avancar', function () {
        avancarInstrucao();
    });

    $("#instrucao").on('click', '.btn-instrucao-voltar', function () {
        voltarInstrucao();
    });

    function avancarInstrucao() {
        if ($(".btn-instrucao-avancar").hasClass('disabled')) {
            return false;
        }

        $("#instrucao-page").val(parseInt($("#instrucao-page").val()) + 1);
        $("#pagina-atual").html(parseInt($("#instrucao-page").val()));
        atualizaBotoesInstrucao();
        mostrarDescricaoInstrucao();

    }

    function atualizaBotoesInstrucao() {
        if (parseInt($("#instrucao-total").val()) <= parseInt($("#instrucao-page").val())) {
            $(".btn-instrucao-avancar").addClass('disabled');
        } else {
            $(".btn-instrucao-avancar").removeClass('disabled');
        }

        if (parseInt($("#instrucao-page").val()) > 1) {
            $(".btn-instrucao-voltar").removeClass('disabled');
        } else {
            $(".btn-instrucao-voltar").addClass('disabled');
        }
    }

    function mostrarDescricaoInstrucao() {
        $('.instrucao-descricao').each(function () {
            $(this).hide();
            if (parseInt($(this).data('pagina')) == parseInt($("#instrucao-page").val())) {
                $(this).show();
            }
        })
    }

    function voltarInstrucao() {
        if ($(".btn-instrucao-voltar").hasClass('disabled')) {
            return false;
        }

        $("#instrucao-page").val(parseInt($("#instrucao-page").val()) - 1);
        $("#pagina-atual").html(parseInt($("#instrucao-page").val()));
        atualizaBotoesInstrucao();
        mostrarDescricaoInstrucao()
    }

    $('.date-mask').mask('00/00/0000', {placeholder: "__/__/____"});
    $('.cnpj-mask').mask('00.000.000/0000-00');
    $('.cpf-mask').mask('000.000.000-00');
    $('.cep-mask').mask('00000-000');
    $('.numero-mask').mask("#0", {reverse: true});
    $('.numero-mask2').mask("#0", {reverse: true, placeholder: '0'});
    $('.dinheiro-mask').mask("#.##0,00", {reverse: true});
    $('.dinheiro-mask2').mask("#.##0,00", {reverse: true, placeholder: '0,00'});
    $('.dia-mask').mask("09");
    $(".fone-mask").mask("(00) 0000-00009");
    $('.cnae-mask').mask('0000-0/00');
    $('.irpf-mask').mask('000000000000');
    $('.pis-mask').mask('000.00000.00-0');
      $(".time-mask").mask("99:99", {placeholder: "--:--", clearIfNotMatch: true});
    $(".multiplier-mask").mask('##0%', {reverse: true, placeholder: "0%"});

    jQuery.support.cors = true;
    /*$('.cep-mask').on('keyup', function () {
     if ($(this).val().length == 9) {
     var cep = $(this).val().match(/\d/g);
     cep = cep.join("");
     $.post('http://api.postmon.com.br/v1/cep/'+cep,{crossDomain: true}, function (data) {
     console.log(data)
     });
     }
     })*/
});


        </script>
        @show
    </head>
    <body data-spy="scroll" data-target="#navbar-main" data-offset="200" class="{{Request::is('/') ? '' : 'bg-ltblue'}}">
        <section id="navbar">
            <div class="navbar navbar-default navbar-fixed-top">
                <div class="{{Request::is('/') || Request::is('noticias*') ? 'container' : 'container-fluid'}}">
                    <div class="navbar-header">
                        <a href="{{route('home')}}" class="navbar-brand"><img src="{{url('public/images/logotipo-pequeno.png')}}" /></a>
                        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="navbar-collapse collapse" id="navbar-main">
                        <ul class="nav navbar-nav navbar-right" role="tablist">
                            @if(Request::is('/'))
                            <li class="dropdown">
                                <a href="#inicio" id="nav-inicio">Início</a>
                            </li>
                            <li>
                                <a href="#como-funciona">Como funciona</a>
                            </li>
                            <li>
                                <a href="#planos">Simulação</a>
                            </li>
                            <li>
                                <a href="#faq">Perguntas Frequentes</a>
                            </li>
                            <li>
                                <a href="#noticias">Notícias</a>
                            </li>
                            <li>
                                <a href="#contato">Contato</a>
                            </li>
                            @endif
                            @if(Request::is('noticias*'))
                            <li class="dropdown">
                                <a href="{{url('/')}}#inicio" id="nav-inicio">Início</a>
                            </li>
                            <li>
                                <a href="{{url('/')}}#como-funciona">Como funciona</a>
                            </li>
                            <li>
                                <a href="{{url('/')}}#planos">Simulação</a>
                            </li>
                            <li>
                                <a href="{{url('/')}}#faq">Perguntas Frequentes</a>
                            </li>
                            <li>
                                <a href="{{url('/')}}#noticias">Notícias</a>
                            </li>
                            <li>
                                <a href="/#contato">Contato</a>
                            </li>
                            @endif
                            @if(Auth::user())
                            <li><a href="" target="" id="login-link"><b>Olá {{Auth::user()->nome}}</b></a></li>
                            <li><a href="{{route('sair')}}" target="" id="register-link"><b>Sair</b></a></li>
                            @else
                            <li><a href="{{route('registrar')}}" target="" id="register-link"><b>Registrar</b></a></li>
                            <li><a href="{{route('acessar')}}" target="" id="login-link"><b>Entrar</b></a></li>

                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        @yield('content')

    </body>

</html>
