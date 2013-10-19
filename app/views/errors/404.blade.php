@extends('template2')

@section('title')
{{ trans('errors.404.name') }}
@stop

@section('subtitle')
{{ trans('errors.404.title') }}
@stop

@section('content')
<div class="error-block">
  <section class="error">
    <header>
      <div class="icon-block">
        <i class="glyphicon glyphicon-remove-circle"></i>
        <span>{{ trans('errors.404.title') }}</span>
      </div>
      <hr />
    </header>
    <p>{{ trans('errors.404.message') }}</p>
    <hr />
    <a class="btn btn-warning btn-block" href="javascript:void(0)" onclick="history.back()"><i class="glyphicon glyphicon-remove-circle"></i> {{ trans('buttons.return') }}</a>
    <a class="btn btn-primary btn-block" href="{{ URL::to('/') }}"><i class="glyphicon glyphicon-chevron-left"></i> {{ trans('buttons.gotohome') }}</a>
  </section>
</div>
@stop