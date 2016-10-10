<!DOCTYPE html>
<html>
    <head>
        <title>FVM - @yield('header_title')</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @section('css')
        <link rel="stylesheet" type="text/css" href="{{url('public/css/font-awesome.min.css')}}" />
        <link rel="stylesheet" type="text/css" href="{{url('public/css/bootstrap.min.css')}}" />
        <link rel="stylesheet" name="text/css" href="{{url('public/css/fullcalendar.min.css')}}" />
        <link rel="stylesheet" type="text/css" href="{{url('public/css/bootstrap-datepicker3.min.css')}}" />
        <link rel="stylesheet" type="text/css" href="{{url('public/css/animate.css')}}" />
        <link rel="stylesheet" type="text/css" href="{{url('public/css/custom.css')}}" />
        @show
    </head>
    <body>
        <div class="container">
        @yield('main')
        </div>
    </body>
</html>