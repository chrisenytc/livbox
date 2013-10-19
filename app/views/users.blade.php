@extends('template')

@section('title')
{{ trans('users.title') }}
@stop

@section('content')
<a href="{{ URL::to('users/create') }}" class="btn btn-lg btn-success"><i class="glyphicon glyphicon-plus"></i> {{ trans('buttons.adduser') }}</a>
<hr />
<table class="table table-bordered">
    <thead>
        <tr>
        <th>{{ trans('users.id') }}</th>
        <th>{{ trans('users.email') }}</th>
        <th>{{ trans('users.role') }}</th>
        <th>{{ trans('users.status') }}</th>
        <th>{{ trans('users.lastlogin') }}</th>
        <th>{{ trans('users.lastactivity') }}</th>
        <th>{{ trans('users.options') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ Helpers::role_name($user->role) }}</td>
            @if ($user->locked)
                <td><span class="label label-success">{{ trans('buttons.online') }}</span></td>
            @else
                <td><span class="label label-default">{{ trans('buttons.offline') }}</span></td>
            @endif
            <td>{{ Helpers::last_login($user->last_login) }}</td>
            <td>{{ Helpers::last_activity($user->last_activity) }}</td>
            <td>
                <a href='javascript:void(0)' onclick="resetUser({{ $user->id }});" class="btn btn-primary"><i class="glyphicon glyphicon-refresh"></i> {{ trans('buttons.resetsession') }}</a>
                <a href='{{ URL::to("users/$user->id/edit") }}' class="btn btn-warning"><i class="glyphicon glyphicon-pencil"></i> {{ trans('buttons.edit') }}</a>
                <a href='javascript:void(0)' onclick="removeUser({{ $user->id }}, '{{ $user->email }}');" class="btn btn-danger"><i class="glyphicon glyphicon-remove-circle"></i> {{ trans('buttons.remove') }}</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@stop

@section('scripts')
<script type="text/javascript">
var resetUser = function(id)
{
    var confirmation = confirm("{{ trans('messages.js.userreset') }}");
    if(confirmation)
    {
        var url = "{{ URL::to('users/reset') }}/"+id;
        
        $.ajax({
          type: "PUT",
          url: url
        }).done(function( data ) {
          $('#notification').removeAttr('class').addClass("alert alert-"+data.status).text(data.msg);
          setTimeout(function(){
              window.location.reload();
          }, 4000);
        });
    }
}
var removeUser = function(id, email)
{
    var confirmation = confirm("{{ trans('messages.js.userdelete', array('email' => '"+email+"')) }}");
    if(confirmation)
    {
        var url = "{{ URL::to('users') }}/"+id;
        
        $.ajax({
          type: "DELETE",
          url: url
        }).done(function( data ) {
          $('#notification').removeAttr('class').addClass("alert alert-"+data.status).text(data.msg);
          setTimeout(function(){
              window.location.reload();
          }, 4000);
        });
    }
}
</script>
@stop