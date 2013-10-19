@extends('template2')

@section('title')
{{ trans('errors.403.name') }}
@stop

@section('subtitle')
{{ trans('errors.403.title') }}
@stop

@section('content')
<div class="error-block">
  <section class="error">
    <header>
      <div class="icon-block">
        <i class="glyphicon glyphicon-remove-circle"></i>
        <span>{{ trans('errors.403.title') }}</span>
      </div>
      <hr />
    </header>
    <p>{{ trans('errors.403.message') }}</p>
    <hr />
     <a class="btn btn-warning btn-block" href="javascript:void(0)" onclick="history.back()"><i class="glyphicon glyphicon-remove-circle"></i> {{ trans('buttons.return') }}</a>
    <a class="btn btn-primary btn-block" href="{{ URL::to('/') }}"><i class="glyphicon glyphicon-chevron-left"></i> {{ trans('buttons.gotohome') }}</a>
  </section>
</div>
@stop