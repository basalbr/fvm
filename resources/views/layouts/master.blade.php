<html>
    <head>
        <title>MTCloud - @yield('header_title')</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @section('css')
        {!! HTML::style('public/css/font-awesome.min.css') !!}
        {!! HTML::style('public/css/bootstrap.min.css') !!}
        {!! HTML::style('public/css/custom.css') !!}
        @show
    </head>
    <body>
        <div id='page-container'>
            @if(Auth::check())
            @section('sidebar-left')
            <nav id='sidebar-left' class='open'>
                <div id='sidebar-left-content'>
                    <ul class="nav-main">
                        <li>
                            <a class="active" href="{{route('index')}}">
                                <i class="fa fa-dashboard"></i><span class="sidebar-mini-hide">Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a class="" href="">
                                <i class="fa fa-users"></i><span class="sidebar-mini-hide">Contatos</span>
                            </a>
                        </li>
                        <li>
                            <a class="" href="">
                                <i class="fa fa-key"></i><span class="sidebar-mini-hide">Licenças</span>
                            </a>
                        </li>
                        <li>
                            <a class="" href="{{route('logout')}}">
                                <i class="fa fa-key"></i><span class="sidebar-mini-hide">Sair</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            @show
            @endif
            @section('navbar-top')
            <header id='navbar-top'>
                @if(Auth::check())
                <a class="btn btn-icon-toggle">
                    <i class="fa fa-bars"></i>
                </a>
                @endif
                <a href='{{route('index')}}' class='navbar-logo'>
                    <img src="{{url('public/images/navbar-logo.png')}}" style="max-width: 100%"/>
                </a>
            </header>
            @show

            <main id='main-container' class="container-fluid">
                @yield('main-content')
                <div class='clearfix'></div>
                @section('footer')

                <footer id='page-footer'>
                    <div class='container text-center'>
                        <div class='hidden-xs hidden-sm col-md-4'>
                            <h3>Outros produtos</h3>
                            <ul class='list-unstyled'>
                                <li>
                                    <a href=''>MTReports</a>
                                </li>
                                <li>
                                    <a href=''>MTRoteiriza</a>
                                </li>
                                <li>
                                    <a href=''>MTSonar</a>

                                </li>
                                <li>
                                    <a href=''>MTVendors</a>
                                </li>
                            </ul>
                        </div>
                        <div class='hidden-xs hidden-sm col-md-4'>
                            <h3>MTCloud</h3>
                            <ul class='list-unstyled'> 
                                <li>
                                    <a href=''>Contato</a>
                                </li>
                                <li>
                                    <a href=''>Criar nova conta</a>
                                </li>
                                <li>
                                    <a href=''>Sobre</a>
                                </li>
                                <li>
                                    <a href=''>Termos de uso</a>
                                </li>
                            </ul>
                        </div>
                        <div class='hidden-xs hidden-sm col-md-4'>
                            <h3>Microton</h3>
                            <ul class='list-unstyled'>
                                <li>
                                    <a href=''>Acesse nosso site</a>
                                </li>
                                <li>
                                    <a href=''>Fale conosco</a>
                                </li>
                            </ul>
                        </div>
                        <div class='clearfix'></div>
                    </div>
                    <div class='clearfix'></div>
                </footer>
                @show
            </main>
        </div>
    </body>
    @section('js')
    {!! HTML::script('public/js/jquery-2.1.4.min.js') !!}
    {!! HTML::script('public/js/bootstrap.min.js') !!}
    @show
</html>
