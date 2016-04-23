<html>
    <head>
        <title>FVM - @yield('header_title')</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @section('css')
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
    // $.xhrPool and $.ajaxSetup are the solution
    $('#calendar').fullCalendar(
        {
            lang: 'pt-br',
    events: [
        {
            title: 'Pagar guia do imposto X',
            start: '2016-04-11'
        },
        {
            title: 'Pagar guia do imposto Y',
            start: '2016-04-12'
        }
        // etc...
    ],
    color: 'yellow',   // an option!
    textColor: 'black' // an option!
}
    )
    $('.cnpj-mask').mask('00.000.000/0000-00');
    $('.cep-mask').mask('00000-000');
    $('.numero-mask').mask("#0", {reverse: true});
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
    <body>
        <section id="navbar">
            <div class="navbar navbar-default navbar-fixed-top">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a href="" class="navbar-brand"><img src="{{url('public/images/navbar-logo.png')}}" style="max-width: 100%"/></a>
                        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="navbar-collapse collapse" id="navbar-main">
                        <ul class="nav navbar-nav">
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes">Themes <span class="caret"></span></a>
                                <ul class="dropdown-menu" aria-labelledby="themes">
                                    <li><a href="../default/">Default</a></li>
                                    <li class="divider"></li>
                                    <li><a href="../cerulean/">Cerulean</a></li>
                                    <li><a href="../cosmo/">Cosmo</a></li>
                                    <li><a href="../cyborg/">Cyborg</a></li>
                                    <li><a href="../darkly/">Darkly</a></li>
                                    <li><a href="../flatly/">Flatly</a></li>
                                    <li><a href="../journal/">Journal</a></li>
                                    <li><a href="../lumen/">Lumen</a></li>
                                    <li><a href="../paper/">Paper</a></li>
                                    <li><a href="../readable/">Readable</a></li>
                                    <li><a href="../sandstone/">Sandstone</a></li>
                                    <li><a href="../simplex/">Simplex</a></li>
                                    <li><a href="../slate/">Slate</a></li>
                                    <li><a href="../spacelab/">Spacelab</a></li>
                                    <li><a href="../superhero/">Superhero</a></li>
                                    <li><a href="../united/">United</a></li>
                                    <li><a href="../yeti/">Yeti</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="../help/">Help</a>
                            </li>
                            <li>
                                <a href="http://news.bootswatch.com">Blog</a>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="download">Default <span class="caret"></span></a>
                                <ul class="dropdown-menu" aria-labelledby="download">
                                    <li><a href="http://jsfiddle.net/bootswatch/mLascy62/">Open Sandbox</a></li>
                                    <li class="divider"></li>
                                    <li><a href="../bower_components/bootstrap/dist/css/bootstrap.min.css">bootstrap.min.css</a></li>
                                    <li><a href="../bower_components/bootstrap/dist/css/bootstrap.css">bootstrap.css</a></li>
                                    <li class="divider"></li>
                                    <li><a href="../bower_components/bootstrap/less/variables.less">variables.less</a></li>
                                    <li class="divider"></li>
                                    <li><a href="../bower_components/bootstrap-sass-official/assets/stylesheets/bootstrap/_variables.scss">_variables.scss</a></li>
                                </ul>
                            </li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            @if(Auth::user())
                            <li><a href="" target="" id="login-link"><b>Olá {{Auth::user()->nome}}</b></a></li>
                            <li><a href="{{route('sair')}}" target="" id="register-link"><b>Sair</b></a></li>
                            @else
                            <li><a href="" target="" id="login-link"><b>Entrar</b></a></li>
                            <li><a href="" target="" id="register-link"><b>Registrar</b></a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        @yield('content')

    </body>

</html>
