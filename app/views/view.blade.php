@extends('template2')

@section('content')
<div class="public-box">
    <div>
        <div class="file-info">
            <header>
                <h1 class="text-center">{{ Helpers::title(TRUE) }}</h1>
            </header>
            <div class="file-box">
                <p>{{ $file->name }}</p>
                <div class="icon"><i class="glyphicon glyphicon-file"></i></div>
                <div class="file-size">
                    <span class="label label-info">{{ $file->size }}</span>
                </div>
            </div>
            <a href="{{ URL::to('archives/save') }}/{{ $file->share_id }}" class="btn btn-lg btn-primary btn-block"><i class="glyphicon glyphicon-export"></i> {{ trans('buttons.sendtome') }}</a>
            <a href="{{ URL::to('download') }}/{{ $file->path }}" class="btn btn-lg btn-success btn-block"><i class="glyphicon glyphicon-cloud-download"></i> {{ trans('buttons.download') }}</a>
        </div>
        
    </div>
</div>
@stop