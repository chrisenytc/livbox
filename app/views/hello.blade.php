@extends('template')

@section('title')
{{ trans('home.title') }}
@stop

@section('content')

<div class="jumbotron">
    <div class="container">
        <h1>{{ trans('home.welcome') }}</h1>
        <p>{{ trans('home.message') }}</p>
        <p><a href="{{ URL::to('logout') }}" class="btn btn-primary btn-lg"><i class="glyphicon glyphicon-off"></i> {{ trans('buttons.logout') }}</a></p>
    </div>
</div>
@stop