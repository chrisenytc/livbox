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
<div id="main-container">
    <div class="row">
        <div class="col-lg-2">
            <header class="header">
                <div class="logo">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="{{ Helpers::title(TRUE) }}">
                </div>
                <div class="profile">
                    <a href="{{ URL::to('me') }}" data-toggle="tooltip" title="{{ Auth::user()->email }}"><img async src="http://www.gravatar.com/avatar/{{ md5(Auth::user()->email) }}?s=60" class="img-circle"></a>
                    <br />
                    <small><b>{{ Helpers::role_name() }}</b></small>
                </div>
                <nav class="main-nav">
                    <ul>
                        <li><a href="{{ URL::to('/') }}"><i class="glyphicon glyphicon-home"></i> {{ trans('general.menu.dashboard') }}</a></li>
                        <li><a href="{{ URL::to('archives') }}"><i class="glyphicon glyphicon-folder-close"></i> {{ trans('general.menu.archives') }}</a></li>
                        <li><a href="{{ URL::to('users') }}"><i class="glyphicon glyphicon-user"></i> {{ trans('general.menu.users') }}</a></li>
                        <li><a href="{{ URL::to('settings') }}"><i class="glyphicon glyphicon-wrench"></i> {{ trans('general.menu.settings') }}</a></li>
                        <li><a href="{{ URL::to('logout') }}"><i class="glyphicon glyphicon-off"></i> {{ trans('general.menu.logout') }}</a></li>
                    </ul>
                </nav>
            </header>
        </div>
        <div class="col-lg-10">
            <section class="page-content">
                <!--Page Title-->
                <div class="page-header">
                    <div class="pull-left">
                        <h2>
                            @section('title')
                            @show
                            <small>
                                @section('subtitle')
                                @show
                            </small>
                        </h2>
                    </div>
                    <div class="pull-right">
                        {{ trans('general.welcome', array('email' => Auth::user()->email)) }}
                        <br />
                        <small><i>{{ trans('general.last_login', array('time' => Helpers::last_login())) }}</i></small>
                    </div>
                    <div class="clear"></div>
                </div>
                <div id="notification"></div>
                @if(Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
                @endif
                <!--Page Content-->
                <div class="page-block">
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
                </div>
                <footer>
                    <hr />
                    <div class="copyright">
                        {{ trans('general.copyright', array('year' => date('Y'))) }} <br />
                        {{ trans('general.license') }}
                    </div>
                </footer>
            </section>
        </div>
    </div>
</div>
<!--Core-->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="{{ asset('assets/js/app.min.js') }}"></script>
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