@extends('template2')

@section('content')
<div class="login-box">
    <div>
        @if (Session::has('error'))
            {{ trans(Session::get('reason')) }}
        @endif
        <form class="form-signin" method="post" action="{{ URL::to('forgot/remind') }}">
            <img class="form-signin-heading text-center" src="{{ asset('assets/img/livbox-white.png') }}" alt="{{ Helpers::title(TRUE) }}">
            <h5 class="form-signin-heading text-center">{{ trans('auth.reset.message') }}</h5>
            <input type="text" class="form-control" name="email" placeholder="{{ trans('auth.email') }}">
            <input type="password" class="form-control" name="password" placeholder="{{ trans('auth.password') }}">
            <input type="password" class="form-control" name="password_confirmation" placeholder="{{ trans('auth.password_confirmation') }}">
            <input type="hidden" class="form-control" name="token" value="{{ $token }}">
            <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" />
            <br />
            <input type="submit" class="btn btn-lg btn-warning btn-block" value="{{ trans('buttons.save') }}">
        </form>
    </div>
</div>
@stop