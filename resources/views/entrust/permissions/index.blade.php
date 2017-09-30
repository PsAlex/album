@extends('layout.app')
@section('title')
    权限管理-
@endsection
@section('content')
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading">新建权限</div>
            <div class="panel-body">
                <form action="{{url('/admin/permissions')}}" method="POST" role="form">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <lable class="control-label">名称:</lable>

                        <input type="text" class="form-control input-sm" required name="name" autocomplete="off">

                    </div>
                    <div class="form-group">
                        <lable class="control-label">显示名称:</lable>
                        <input type="text" class="form-control input-sm" name="display_name" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <lable class="control-label">描述:</lable>
                        <input type="text" class="form-control input-sm" name="description" autocomplete="off">
                    </div>
                    <div class="form-group ">
                        <button type="submit" class="btn btn-sm btn-primary pull-right">新建权限</button>
                    </div>
                    <div class="pull-right">
                        <p> 权限名称示例</p>

                        <div class="input-group">
                            <span class="input-group-addon">添加</span>
                            <input type="text" class="form-control input-sm" disabled value="****.store">
                        </div>
                    </div>
                    <br>
                    <table class="table">
                        <tr>
                            <td>添加</td>
                            <td>删除</td>
                            <td>修改</td>
                            　
                        </tr>
                        <tr>
                            <td>store</td>
                            <td>destroy</td>
                            <td>update</td>

                        </tr>
                    </table>


                </form>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <table class="table table-responsive text-center">
            <thead>
            <tr>
                <td>名称</td>
                <td>显示名称</td>
                <td>描述</td>
                <td colspan="2">
                    <form action="{{url('/admin/permissions?s=')}}" method="get">
                        <input class="form-control"
                               name="s" autocomplete="off"
                               placeholder="搜索输入...">
                    </form>
                </td>
            </tr>
            </thead>
            <tbody>
            @foreach($perms as $perm)
                <tr>
                    <td>{{$perm->name}}</td>
                    <td>{{$perm->display_name}}</td>
                    <td>{{$perm->description}}</td>
                    <td>
                        　
                        <button class="btn btn-primary" data-toggle="modal"
                                data-target="#edit" data-url="{{url('/admin/permissions/'.$perm->id)}}">编辑
                        </button>


                    </td>
                    <td>
                        <button type="button" class="btn btn-danger" 　
                                data-toggle="modal"
                                data-target="#delete" data-url="{{url('/admin/permissions/'.$perm->id)}}"
                        >删除
                        </button>


                    </td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td colspan="5">
                    <nav class="text-center">{!!$perms->appends(['sort'=>$s])->render() !!} </nav>
                </td>
            </tr>
            </tfoot>
        </table>

    </div>
    @include('layout.model.delete',['modal_title'=>'删除'])
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
                    modal.find('.modal-body #html').html(data.html_str1);
                }
            });

            modal.find('form').attr('action', url);

        });

    </script>

@endsection