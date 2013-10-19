<!DOCTYPE html>
<html lang="{{ Config::get('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title>{{ Helpers::title() }}</title>
    <meta name="description" content="Login and User Management System" />
    <meta name="keywords" content="login, users, protected, api, html5, css3, javascript" />
    <meta name="author" content="/humans.txt">

    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="canonical" href="" />

    <!--HTML5 IE Support-->
    <!--[if lt IE 9]>
    <script src="{{ asset('assets/lib/html5shiv/dist/html5shiv.js') }} "></script>
    <![endif]-->

    <link rel="shortcut icon" href="{{ asset('assets/img/icons/favicon.ico') }}" type="image/x-icon">
    <!--Style-->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap/3.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.min.css') }}">
    <!--Custom Styles-->
    @section('styles')
    @show

</head>
<body>
<!--Container-->
<div id="main-container" class="container">
    @if(Session::has('success'))
    <div class="alert alert-success">
        {{ Session::get('success') }}
    </div>
    @endif
    @if ( count($errors) > 0)
    <h3>{{ trans('messages.founderrors') }}</h3>
    <br />
    <ul class="nav">
        @foreach ($errors->all() as $e)
        <li><div class="alert alert-danger">{{ $e }}</div></li>
        @endforeach
    </ul>
    @endif
    @yield('content')
    <footer>
        <div class="copyright text-center">
            {{ trans('general.copyright', array('year' => date('Y'))) }} <br />
            {{ trans('general.license') }}
        </div>
    </footer>
</div>
<!--Core-->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script async src="//cdn.jsdelivr.net/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="/assets/js/app.min.js"></script>
<!--Custom JS-->
@section('scripts')
@show

</body>
<!--
          |||                   ||| 
|||           |||           |||     ||||||||||||
|||       |||  |||         |||  ||| |||      |||
|||       |||   |||       |||   ||| ||||||||||||
|||       |||     |||    |||    ||| |||      |||
||||||||| |||      ||||||       ||| |||      |||
*-----------------------------------------------*
                I LOVE YOU SO MUCH
-->
</html>