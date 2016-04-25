@extends('layouts.master')
@section('header_title', 'Home')
@section('content')
<img id="parallax" src="{{url('public/images/banner.jpg')}}"/>
<section id="inicio" style="height: 600px; overflow: hidden; position: relative; text-align: center">
    <h1 class="text-uppercase">F.V.M</h1>
    <h2 class="text-uppercase">faça você mesmo</h2>
    <a class="btn btn-default text-uppercase">Clique para conhecer</a>
    <a class="btn btn-default text-uppercase" href='{{route('acessar')}}'>clique para acessar</a>
    
</section>
<section id="como-funciona" class="bg-white bg-shadow">
    <div class="container">
        <hr>
        <h1 class="title">Como Funciona</h1>
        <hr>
        <div class="col-md-4">
            <h2>Simples</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec non velit vel mi pretium laoreet. Cras id tellus at diam dictum iaculis non sollicitudin diam. Praesent facilisis vehicula gravida. Proin fermentum, eros nec porta gravida, elit orci semper turpis, eu aliquam lorem odio a nunc. Suspendisse interdum eleifend consequat. Maecenas non condimentum tellus, sed volutpat turpis. Aenean quam turpis, fermentum vel tortor sed, mattis venenatis dolor. Vivamus condimentum sagittis libero id hendrerit. Nullam molestie enim a urna molestie, nec volutpat urna feugiat.

                In finibus sagittis ex, a varius est elementum rutrum. Fusce in facilisis turpis, a tincidunt erat. Phasellus a ex quis leo malesuada ullamcorper. Donec porta eu mauris quis condimentum. Integer imperdiet libero mauris, in mattis ligula feugiat non. Vestibulum vel imperdiet erat, quis aliquet erat. Nulla non ligula convallis, eleifend augue facilisis, auctor quam. Maecenas ac facilisis diam. Fusce rutrum eros neque, tincidunt viverra ligula vestibulum non. Etiam posuere venenatis nisl nec molestie. Sed in nulla vel diam consequat semper. Aliquam nec lectus nunc. Vestibulum odio lorem, tempor nec luctus quis, eleifend eget nulla.</p>
        </div>
        <div class="col-md-4">
            <h2>Fácil</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec non velit vel mi pretium laoreet. Cras id tellus at diam dictum iaculis non sollicitudin diam. Praesent facilisis vehicula gravida. Proin fermentum, eros nec porta gravida, elit orci semper turpis, eu aliquam lorem odio a nunc. Suspendisse interdum eleifend consequat. Maecenas non condimentum tellus, sed volutpat turpis. Aenean quam turpis, fermentum vel tortor sed, mattis venenatis dolor. Vivamus condimentum sagittis libero id hendrerit. Nullam molestie enim a urna molestie, nec volutpat urna feugiat.

                In finibus sagittis ex, a varius est elementum rutrum. Fusce in facilisis turpis, a tincidunt erat. Phasellus a ex quis leo malesuada ullamcorper. Donec porta eu mauris quis condimentum. Integer imperdiet libero mauris, in mattis ligula feugiat non. Vestibulum vel imperdiet erat, quis aliquet erat. Nulla non ligula convallis, eleifend augue facilisis, auctor quam. Maecenas ac facilisis diam. Fusce rutrum eros neque, tincidunt viverra ligula vestibulum non. Etiam posuere venenatis nisl nec molestie. Sed in nulla vel diam consequat semper. Aliquam nec lectus nunc. Vestibulum odio lorem, tempor nec luctus quis, eleifend eget nulla.</p>
        </div>
        <div class="col-md-4">
            <h2>Dinâmico</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec non velit vel mi pretium laoreet. Cras id tellus at diam dictum iaculis non sollicitudin diam. Praesent facilisis vehicula gravida. Proin fermentum, eros nec porta gravida, elit orci semper turpis, eu aliquam lorem odio a nunc. Suspendisse interdum eleifend consequat. Maecenas non condimentum tellus, sed volutpat turpis. Aenean quam turpis, fermentum vel tortor sed, mattis venenatis dolor. Vivamus condimentum sagittis libero id hendrerit. Nullam molestie enim a urna molestie, nec volutpat urna feugiat.

                In finibus sagittis ex, a varius est elementum rutrum. Fusce in facilisis turpis, a tincidunt erat. Phasellus a ex quis leo malesuada ullamcorper. Donec porta eu mauris quis condimentum. Integer imperdiet libero mauris, in mattis ligula feugiat non. Vestibulum vel imperdiet erat, quis aliquet erat. Nulla non ligula convallis, eleifend augue facilisis, auctor quam. Maecenas ac facilisis diam. Fusce rutrum eros neque, tincidunt viverra ligula vestibulum non. Etiam posuere venenatis nisl nec molestie. Sed in nulla vel diam consequat semper. Aliquam nec lectus nunc. Vestibulum odio lorem, tempor nec luctus quis, eleifend eget nulla.</p>
        </div>
    </div>
    <div class="clearfix"></div>
</section>
<section id="planos" class="bg-dark">
    <div class="container">
        <hr>
        <h1 class="title">Planos</h1>
        <hr>
        <div class="pricing-table">
            <div class="col-lg-4 col-md-4 col-sm-4 ">
                <ul class="plan plan1">
                    <li class="plan-name">
                        Basic
                    </li>
                    <li class="plan-price">
                        <h3> $19 <span class="price-cents">99</span><span class="price-month">/month</span></h3>
                    </li>
                    <li>
                        <strong>5GB</strong> Storage
                    </li>
                    <li>
                        <strong>1GB</strong> RAM
                    </li>
                    <li>
                        <strong>400GB</strong> Bandwidth
                    </li>
                    <li>
                        <strong>10</strong> Email Address
                    </li>
                    <li>
                        <strong>Forum</strong> Support
                    </li>
                    <li class="plan-action">
                        <a href="#" class="btn btn-blue btn-lg"> Signup </a>
                    </li>
                </ul>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 ">
                <ul class="plan plan2 featured">
                    <li class="plan-name">
                        Standard
                    </li>
                    <li class="plan-price">
                        <h3> $29 <span class="price-cents">99</span><span class="price-month">/month</span></h3>
                    </li>
                    <li>
                        <strong>5GB</strong> Storage
                    </li>
                    <li>
                        <strong>1GB</strong> RAM
                    </li>
                    <li>
                        <strong>400GB</strong> Bandwidth
                    </li>
                    <li>
                        <strong>10</strong> Email Address
                    </li>
                    <li>
                        <strong>Forum</strong> Support
                    </li>
                    <li class="plan-action">
                        <a href="#" class="btn btn-blue btn-lg"> Signup </a>
                    </li>
                </ul>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 ">
                <ul class="plan plan3">
                    <li class="plan-name">
                        Advanced
                    </li>
                    <li class="plan-price">
                        <h3> $49 <span class="price-cents">99</span><span class="price-month">/month</span></h3>
                    </li>
                    <li>
                        <strong>50GB</strong> Storage
                    </li>
                    <li>
                        <strong>8GB</strong> RAM
                    </li>
                    <li>
                        <strong>1024GB</strong> Bandwidth
                    </li>
                    <li>
                        <strong>Unlimited</strong> Email Address
                    </li>
                    <li>
                        <strong>Forum</strong> Support
                    </li>
                    <li class="plan-action">
                        <a href="#" class="btn btn-blue btn-lg"> Signup </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="clearfix"></div>
</section>

@stop