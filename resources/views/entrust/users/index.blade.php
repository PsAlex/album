@extends('layout.app')
@section('title')
用户管理-
@endsection
@section('content')
<div class="row text-center">
    <div class="col-md-12">
        <form action="{{url('admin/users?s=')}}" method="get" class="col-md-4">
            <input type="text" class="form-control input-sm" name="s" autofocus placeholder="输入email">
        </form>
    </div>
    <div class="col-md-12">
        <br>
        @if (sizeof($users)>0)
        <div class="blog-masonry masonry-true">
            @foreach($users as $user)
            <div class="post-masonry col-md-4 col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{$user->name}}
                        <a class="role-btn btn btn-xs pull-right" data-toggle="modal"data-target="#delete" data-url="{{url('/admin/users/'.$user->id)}}">
                            <span class=" glyphicon glyphicon-remove"></span>
                        </a>
                        <a class="role-btn btn btn-xs pull-right" data-toggle="modal"data-target="#edit" data-url="{{url('/admin/users/'.$user->id)}}">
                            <span class="glyphicon glyphicon-cog"></span>
                        </a>　
                    </div>
                    <div class="panel-body">
                        Email : {{$user->email}}
                        <hr>
                        @if (sizeof($user->roles))
                        <table class="table">
                            <thead>
                                <tr>
                                    <td>role</td>
                                    <td>perms</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->roles as $role)
                                <tr>
                                    <td><a href="{{url('admin/roles')}}">{{$role->display_name or $role->name}}</a></td>
                                    <td>
                                        <ul class="list-unstyled">
                                            @foreach($role->perms as $perm)
                                            <li>{{$perm->display_name or $perm->name}}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <p>没有所属角色</p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-center">未找到匹配记录！</p>
        @endif
    </div>
    <nav class="text-center">{!!$users->appends(['sort'=>$s])->render() !!} </nav>
</div>
@include('layout.model.delete',['modal_title'=>'删 除','modal_body'=>'确定要删除该用户？'])
@include('layout.model.user',['modal_title'=>'编 辑','method'=>'put'])
@endsection
@section('script')
<script type="text/javascript">
    $('#edit').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var url = button.data('url');
        var modal = $(this);
        $.ajax({
            url: url+'/edit',
            type: "get",
            async: true,
            dataType: "json",
            success: function (data) {
                modal.find('.modal-body #email').text(data.json_str.email);
                modal.find("input[name='name']").attr('value', data.json_str.name);
                modal.find("input[name='display_name']").attr('value', data.json_str.display_name);
                modal.find("input[name='description']").attr('value', data.json_str.description);
                modal.find('.modal-body #html').html(data.html_str);
            }
        });
        modal.find('form').attr('action', url);
    });
</script>
<script type="text/javascript" src="{{ asset('js/min/plugins.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/min/main.min.js') }}"></script>
@endsection