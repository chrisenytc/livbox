@extends('template2')

@section('content')
<div class="login-box">
    <div>
        <form class="form-signin" method="post" action="{{ URL::to('login') }}">
            <img class="form-signin-heading text-center" src="{{ asset('assets/img/livbox-white.png') }}" alt="{{ Helpers::title(TRUE) }}">
            <h5 class="form-signin-heading text-center">{{ trans('auth.login.message') }}</h5>
            <input type="text" class="form-control" name="email" placeholder="{{ trans('auth.email') }}">
            <input type="password" class="form-control" name="password" placeholder="{{ trans('auth.password') }}">
            <div class="checkbox">
              <input type="checkbox" name="remind" value="true"> {{ trans('auth.remember') }}
            </div>
            <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" />
            <button type="submit" class="btn btn-lg btn-primary btn-block"><i class="glyphicon glyphicon-check"></i> {{ trans('buttons.login') }}</button>
            <a href="{{ URL::to('forgot') }}" class="btn btn-lg btn-warning btn-block"><i class="glyphicon glyphicon-hand-right"></i> {{ trans('buttons.forgotpass') }}</a>
        </form>
    </div>
</div>
@stop