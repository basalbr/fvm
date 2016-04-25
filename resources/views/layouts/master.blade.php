<!DOCTYPE html>
<html>
    <head>
        <title>FVM - @yield('header_title')</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @section('css')
        <link href='https://fonts.googleapis.com/css?family=Raleway:400,700,700italic,400italic' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="{{url('public/css/font-awesome.min.css')}}" />
        <link rel="stylesheet" type="text/css" href="{{url('public/css/bootstrap.min.css')}}" />
        <link rel="stylesheet" name="text/css" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.6.1/fullcalendar.min.css" />
        <link rel="stylesheet" name="text/css" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.6.1/fullcalendar.print.css" />
        <link rel="stylesheet" type="text/css" href="{{url('public/css/custom.css')}}" />
        @show
        @section('js')

        <script type="text/javascript" src="{{url('public/js/jquery-2.1.4.min.js')}}"></script>
        <script type="text/javascript" src="{{url('public/js/moment.min.js')}}"></script>
        <script type="text/javascript" src="{{url('public/js/bootstrap.min.js')}}"></script>
        <script type="text/javascript" src="{{url('public/js/mask.js')}}"></script>
        <script name="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.6.1/fullcalendar.min.js"></script>
        <script type="text/javascript" src="{{url('public/js/pt-br.js')}}"></script>
        <script type="text/javascript">
$(function () {
    $('a.page-scroll').bind('click', function (event) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top - 50
        }, 1000, 'easeInOutExpo');
        event.preventDefault();
    });
    // $.xhrPool and $.ajaxSetup are the solution
    $('#calendar').fullCalendar({
        lang: 'pt-br',
        events: {
            url: "{{route('ajax-calendar')}}",
            type: 'POST'
        }
    });
    $('.cnpj-mask').mask('00.000.000/0000-00');
    $('.cep-mask').mask('00000-000');
    $('.numero-mask').mask("#0", {reverse: true});
    $('.dia-mask').mask("09");
    $(".fone-mask").mask("(00) 0000-00009")
    $('.cnae-mask').mask('0000-0/00')
    $('.cnae-search').on('keyup', function () {
        if ($(this).val().length > 2) {
            $.post("{{route('ajax-cnae')}}", {'search': $(this).val()}, function (data) {
                var html = '';
                try {
                    $('.cnae-search-box .result').empty();
                    if (data.length) {
                        for (i in data) {
                            html += '<div class="cnae-item" data-val="' + data[i].codigo + '" data-id="' + data[i].id + '">';
                            html += '<b>' + data[i].codigo + '</b>' + ' ' + data[i].descricao;
                            html += '</div>';
                        }
                        $('.cnae-search-box .result').html(html);
                        $('.cnae-search-box').show();
                    } else {
                        $('.cnae-search-box .result').empty();
                        $('.cnae-search-box').hide();
                    }
                } catch (e) {
                    $('.cnae-search-box').hide();
                }
            });
        } else {
            $('.cnae-search-box .result').empty();
            $('.cnae-search-box').hide();
        }
    })
    $('.cnae-search-box .result').on('click', '.cnae-item', function () {
        console.log($(this).data('val'));
        $('.cnae-search').after('<input type="hidden" value="' + $(this).data('id') + '" name="cnaes[]"/>');
        $('.cnae-search').after('<div class="col-xs-12"><a data-id="' + $(this).data('id') + '" class="remove-cnae">' + $(this).data('val') + '</a></div>');
        $('.cnae-search').val('');
        $('.cnae-search-box .result').empty();
        $('.cnae-search-box').hide();
    })
    $('.form-group').on('click', 'div .remove-cnae', function () {
        var id = $(this).data('id');
        $('input[type=hidden]').each(function () {
            if ($(this).val() == id) {
                $(this).remove();
            }
        })
        $(this).parent().remove();
    })
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
})


        </script>
        @show
    </head>
    <body data-spy="scroll" data-target=".navbar" data-offset="400">
        <section id="navbar">
            <div class="navbar navbar-default navbar-fixed-top">
                <div class="container">
                    <div class="navbar-header">
                        <a href="" class="navbar-brand">F.V.M</a>
                        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="navbar-collapse collapse" id="navbar-main">
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a href="#inicio" id="nav-inicio">Início</a>
                            </li>
                            <li>
                                <a href="#como-funciona">Como funciona</a>
                            </li>
                            <li>
                                <a href="#planos">Planos</a>
                            </li>
                            <li>
                                <a href="#contato">Contato</a>
                            </li>
                            @if(Auth::user())
                            <li><a href="" target="" id="login-link"><b>Olá {{Auth::user()->nome}}</b></a></li>
                            <li><a href="{{route('sair')}}" target="" id="register-link"><b>Sair</b></a></li>
                            @else
                            <li><a href="" target="" id="register-link"><b>Registrar</b></a></li>
                            <li><a href="" target="" id="login-link"><b>Entrar</b></a></li>

                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        @yield('content')

    </body>

</html>
