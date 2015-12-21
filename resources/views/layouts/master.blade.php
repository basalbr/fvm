<html>
    <head>
        <title>FVM - @yield('header_title')</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @section('css')
        <link rel="stylesheet" type="text/css" href="{{url('public/css/font-awesome.min.css')}}" />
        <link rel="stylesheet" type="text/css" href="{{url('public/css/bootstrap.min.css')}}" />
        <link rel="stylesheet" type="text/css" href="{{url('public/css/custom.css')}}" />
        @show
        @section('js')
        <script type="text/javascript" src="{{url('public/js/jquery-2.1.4.min.js')}}"></script>
        <script type="text/javascript" src="{{url('public/js/bootstrap.min.js')}}"></script>
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
                            <li><a href="" target="" id="login-link"><b>Entrar</b></a></li>
                            <li><a href="" target="" id="register-link"><b>Registrar</b></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        @yield('content')
       
    </body>

</html>
