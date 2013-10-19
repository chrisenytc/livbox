@extends('template')

@section('title')
{{ trans('archives.title') }}
@stop

@section('content')
<div class="actions">
  <a class="btn btn-warning" onclick="window.location=document.referrer;" href="javascript:void(0)"><i class="glyphicon glyphicon-chevron-left"></i> {{ trans('buttons.back') }}</a>
  <a id="uploadBtn" class="btn btn-info" href="javascript:void(0)"><i class="glyphicon glyphicon-cloud-upload"></i> {{ trans('buttons.upload') }}</a>
  <a id="newFolderBtn" class="btn btn-success" href="javascript:void(0)"><i class="glyphicon glyphicon-plus"></i> {{ trans('buttons.newfolder') }}</a>
</div>
<hr />
<form id="uploadForm" class="hide" method="post" action="{{ URL::to('archives/upload') }}" enctype="multipart/form-data">
  <input type="file" name="files" />
  <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" />
  <br />
  <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-cloud-upload"></i> {{ trans('buttons.send') }}</button>
  <hr />
</form>
<form id="newFolderForm" class="hide" method="post" action="{{ URL::to('archives/create') }}">
  <div class="row">
      <div class="col-lg-4">
          <input type="text" class="form-control" name="name" placeholder="{{ trans('archives.foldername') }}" />
          <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" />
      </div>
  </div>
  <br />
  <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> {{ trans('buttons.create') }}</button>
  <hr />
</form>
<table class="table table-hover table-color">
  <thead>
    <tr>
      <th>{{ trans('archives.name') }}</th>
      <th>{{ trans('archives.size') }}</th>
      <th>{{ trans('archives.modified') }}</th>
      <th>{{ trans('archives.options') }}</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($files as $f)
      @if ($f != '.' && $f != '..')
          <tr>
          @if (is_file($filepath = Helpers::file_path($path).$f))
              <td><a href="javascript:void(0)"><i class="glyphicon glyphicon-file icon-large"></i> {{ $f }}</a></td>
          @elseif (is_dir($filepath))
              <td><a href="{{ URL::to('archives/'.Crypt::encrypt($path.$f.DIRECTORY_SEPARATOR)) }}"><i class="glyphicon glyphicon-folder-close icon-large"></i> {{ $f }}</a></td>
          @else
              <td><a href="#"><i class="glyphicon glyphicon-block icon-large"></i> {{ $f }}</a></td>
          @endif
          <td>{{ Helpers::formatsize(filesize($filepath)) }}</td>
          <td>{{ date ("Y/m/d H:i:s", filemtime($filepath)) }}</td>
          <td>
              @if(is_file($filepath))
                  <a class="btn btn-success" href="{{ URL::to('archives/download/'.Crypt::encrypt($path.$f)) }}"><i class="glyphicon glyphicon-cloud-download"></i> {{ trans('buttons.download') }}</a>
              @else
                  <a class="btn btn-info" href="{{ URL::to('archives/'.Crypt::encrypt($path.$f.DIRECTORY_SEPARATOR)) }}"><i class="glyphicon glyphicon-folder-close"></i> {{ trans('buttons.viewfolder') }}</a>
              @endif
                  <a class="btn btn-warning rename-popover" href="javascript:void(0)" data-toggle="popover" data-placement="top" data-title="{{ trans('archives.rename') }}" data-html="true" data-content="<input class='form-control' onkeypress=&quot;renameVerify(event, this, &#39;{{ Crypt::encrypt($path.$f) }}&#39;,&#39;{{ md5(Helpers::user_path($path.$f)) }}&#39;)&quot; value='{{ $f }}' type='text'>"><i class="glyphicon glyphicon-pencil"></i> {{ trans('buttons.rename') }}</a>
              @if(is_file($filepath))
                  <a class="btn btn-danger" href="javascript:void(0)" onclick="removeThis('file', '{{ Crypt::encrypt($path.$f) }}', '{{ md5(Helpers::user_path($path.$f)) }}')"><i class="glyphicon glyphicon-remove-circle"></i> {{ trans('buttons.delete') }}</a>
              @else
                  <a class="btn btn-danger" href="javascript:void(0)" onclick="removeThis('dir', '{{ Crypt::encrypt($path.$f.DIRECTORY_SEPARATOR) }}')"><i class="glyphicon glyphicon-remove-circle"></i> {{ trans('buttons.delete') }}</a>
              @endif
              @if(Share::shareExists(md5(Helpers::user_path($path.$f))))
              <a class="btn btn-info share-popover" href="javascript:void(0)" data-toggle="popover" data-placement="top" data-title="{{ trans('archives.sharelink') }}" data-html="true" data-content="<div class='text-center'><input class='form-control' value='{{ URL::to('public') }}/{{ md5(Helpers::user_path($path.$f)) }}' type='text' autofocus><br /><a class='btn btn-danger' href='javascript:void(0)' onclick=&quot;unshareThis(&#39;{{ md5(Helpers::user_path($path.$f)) }}&#39;)&quot;><i class='glyphicon glyphicon-trash'></i> {{ trans('buttons.unshare') }}</a></div>"><i class="glyphicon glyphicon-paperclip"></i> {{ trans('buttons.unshare') }}</a>
              @elseif(is_dir($filepath))
              <a class="btn btn-primary" href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="{{ trans('archives.soon') }}"><i class="glyphicon glyphicon-paperclip"></i> {{ trans('buttons.share') }}</a>
              @else
              <a class="btn btn-primary" href="javascript:void(0)" onclick="shareThis('{{ md5(Helpers::user_path($path.$f)) }}', '{{ Crypt::encrypt($path.$f) }}')"><i class="glyphicon glyphicon-paperclip"></i> {{ trans('buttons.share') }}</a>
              @endif

          </td>
      </tr>
      @endif
    @endforeach
    @if(count($files) == 2)
    <tr>
      <div class="alert alert-info">{{ trans('archives.empty') }}</div>
    </tr>
    @endif
  </tbody>
</table>
@stop

@section('scripts')
<script type="text/javascript">
$(document).ready(function(){

$('#uploadBtn').click(function(){
    $('#uploadForm').toggleClass('hide');
});

$('#newFolderBtn').click(function(){
    $('#newFolderForm').toggleClass('hide');
});

$(".rename-popover").popover();

$(".share-popover").popover();

});
var renameVerify = function(e, data, path, share_id)
{
    if(e.which == 13 || e.keyCode == 13)
    {
        renameThis($(data).val(), path, share_id);
        $(".rename-popover").popover('hide');
    }
}
var renameThis = function(name, path, share_id)
{
    var url = "{{ URL::to('archives/rename') }}";
        
    $.ajax({
      type: "PUT",
      url: url,
      data: {name: name, path: path, share_id: share_id}
    }).done(function( data ) {
      $('#notification').removeAttr('class').addClass("alert alert-"+data.status).text(data.msg);
      setTimeout(function(){
          window.location.reload();
      }, 4000);
    });
}
var removeThis = function(action, path, share_id)
{
    var confirmation = confirm("{{ trans('messages.js.archivedelete') }}");
    if(confirmation)
    {
        var url = "{{ URL::to('archives/delete') }}";
        
        $.ajax({
          type: "DELETE",
          url: url,
          data: {action: action, path: path, share_id: share_id}
        }).done(function( data ) {
          $('#notification').removeAttr('class').addClass("alert alert-"+data.status).text(data.msg);
          setTimeout(function(){
              window.location.reload();
          }, 4000);
        });
    }
}

var shareThis = function(share_id, path)
{
    var confirmation = confirm("{{ trans('messages.js.archiveshare') }}");
    if(confirmation)
    {
        var url = "{{ URL::to('archives/share') }}";
        
        $.ajax({
          type: "PUT",
          url: url,
          data: {share_id: share_id, path: path}
        }).done(function( data ) {
          var el = '<p>'+data.msg+'</p>' + '<br /> <a class="btn btn-lg btn-success" href="'+data.url+'" target="_blank"><i class="glyphicon glyphicon-paperclip"></i> {{ trans('buttons.viewshare') }}</a>';
          var msg = data.error ? data.msg : el;
          $('#notification').removeAttr('class').addClass("alert alert-"+data.status).append(msg);
          setTimeout(function(){
              window.location.reload();
          }, 5000);
        });
    }
}

var unshareThis = function(share_id)
{
    var confirmation = confirm("{{ trans('messages.js.archiveunshare') }}");
    if(confirmation)
    {
        var url = "{{ URL::to('archives/unshare') }}";
        
        $.ajax({
          type: "DELETE",
          url: url,
          data: {share_id: share_id}
        }).done(function( data ) {
          $('#notification').removeAttr('class').addClass("alert alert-"+data.status).text(data.msg);
          $(".share-popover").popover('hide');
          setTimeout(function(){
              window.location.reload();
          }, 4000);
        });
    }
}

</script>
@stop