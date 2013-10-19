@extends('template')

@section('title')
{{ trans('settings.title') }}
@stop

@section('content')
<a href="{{ URL::to('/') }}" class="btn btn-lg btn-warning"><i class="glyphicon glyphicon-chevron-left"></i> {{ trans('buttons.back') }}</a>
<hr />
<form class="form-horizontal" role="form" method="post" action="{{ URL::to('settings') }}">
    <div class="form-group">
        <label for="title" class="col-lg-2 control-label">{{ trans('settings.pagetitle') }}</label>
        <div class="col-lg-10">
            <input type="text" class="form-control" name="title" value="{{ $configs->title }}" placeholder="{{ trans('settings.pagetitle') }}">
        </div>
    </div>
    <div class="form-group">
        <label for="description" class="col-lg-2 control-label">{{ trans('settings.description') }}</label>
        <div class="col-lg-10">
            <input type="text" class="form-control" name="description" value="{{ $configs->description }}" placeholder="{{ trans('settings.description') }}">
        </div>
    </div>
    <div class="form-group">
        <label for="language" class="col-lg-2 control-label">{{ trans('settings.language') }}</label>
        <div class="col-lg-10">
            <select name="language" class="form-control">
              <option {{ Helpers::is_active($configs->language, 'en') }} value="en">{{ trans('settings.languages.en') }}</option>
              <option {{ Helpers::is_active($configs->language, 'pt') }} value="pt">{{ trans('settings.languages.pt') }}</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="timezone" class="col-lg-2 control-label">{{ trans('settings.timezone') }}</label>
        <div class="col-lg-10">
            <select name="timezone" class="form-control">
              @foreach(Helpers::timezones() as $tz => $value)
              <option {{ Helpers::is_active($configs->timezone, $value) }} value="{{ $value }}">{{ $tz }}</option>
              @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="year" class="col-lg-2 control-label">{{ trans('settings.year') }}</label>
        <div class="col-lg-10">
            <input type="text" class="form-control" name="year" value="{{ $configs->year }}" placeholder="{{ trans('settings.year') }}">
        </div>
    </div>
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <div class="form-group">
        <div class="col-lg-offset-2 col-lg-10">
            <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-pencil"></i> {{ trans('buttons.edit') }}</button>
        </div>
    </div>
</form>
@stop