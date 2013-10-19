@extends('template2')

@section('content')
<div class="login-box">
    <div>
        @if (Session::has('error'))
            {{ trans(Session::get('reason')) }}
        @elseif (Session::has('success'))
        <div class="alert alert-success">{{ trans('auth.forgot.messagesuccess') }}</div>
        @endif
        <form class="form-signin" method="post" action="{{ URL::to('forgot/remind') }}">
            <img class="form-signin-heading text-center" src="{{ asset('assets/img/livbox-white.png') }}" alt="{{ Helpers::title(TRUE) }}">
            <h5 class="form-signin-heading text-center">{{ trans('auth.forgot.message') }}</h5>
            <input type="text" class="form-control" name="email" placeholder="{{ trans('auth.email') }}">
            <br />
            <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" />
            <button type="submit" class="btn btn-lg btn-warning btn-block"><i class="glyphicon glyphicon-check"></i> {{ trans('buttons.forgotpass') }}</button>
            <a href="{{ URL::to('login') }}" class="btn btn-lg btn-info btn-block"><i class="glyphicon glyphicon-hand-left"></i> {{ trans('buttons.back') }}</a>
        </form>
    </div>
</div>
@stop