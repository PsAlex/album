@extends('layout.app')
@section('title')
所有角色-
@endsection
@section('content')

<div class="col-md-3">
    <div class="panel panel-default">
        <div class="panel-heading">新建角色</div>
        <div class="panel-body">
            <form action="{{url('/admin/roles')}}" method="POST" role="form">
                {!! csrf_field() !!}
                <div class="form-group">
                    <lable class="control-label">名称:</lable>
                    <div class="input-group">
                        <input type="text" class="form-control input-sm" required name="name" autocomplete="off">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    </div>

                </div>
                <div class="form-group">
                    <lable class="control-label">显示名称:</lable>
                    <input type="text" class="form-control input-sm" name="display_name" autocomplete="off">
                </div>
                <div class="form-group">
                    <lable class="control-label">描述:</lable>
                    <input type="text" class="form-control input-sm" name="description" autocomplete="off">
                </div>
                <div class="checkbox">
                    @foreach($perms as $perm)

                    <label>
                        <input type="checkbox" name="perm[]"
                        value="{{$perm->id}}">{{$perm->display_name or $perm->name}}
                    </label>

                    @endforeach
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-sm btn-primary pull-right">新建角色</button>
                </div>


            </form>
        </div>
    </div>

</div>
<div class="col-md-9 row">
    <div class="blog-masonry masonry-true">
        @foreach($roles as $role)
        <div  class="post-masonry col-md-4 col-sm-6">
            <div class="panel {{$role->name =='admin'? 'panel-success':'panel-default' }} ">
                <div class="panel-heading">

                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                    {{$role->display_name or $role->name}}

                    <a class="role-btn btn btn-xs pull-right" data-toggle="modal"
                    data-target="#delete" data-url="{{url('/admin/roles/'.$role->id)}}">
                    <span class=" glyphicon glyphicon-remove"></span>
                </a>
                　
                　
                <a class="role-btn btn btn-xs pull-right" data-toggle="modal"
                data-target="#edit" data-url="{{url('/admin/roles/'.$role->id)}}">
                <span class="glyphicon glyphicon-cog"></span>
            </a>　


        </div>
        <div class="panel-body">
            <ul class="list-unstyled">
                @foreach($role->perms as $perm)
                <li>
                    <span class="glyphicon glyphicon-tag" aria-hidden="true"></span>
                    {{$perm->display_name or $perm->name}}
                </li>
                @endforeach
            </ul>
        </div>
        @if($role->description)
        <div class="panel-footer">{{$role->description}}</div>
        @endif
    </div>
</div>
@endforeach
</div>
</div>



@include('layout.model.delete',['modal_title'=>'删除','modal_body'=>'确定要删除该条数据？'])
@include('layout.model.edit',['modal_title'=>'编辑'])
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
