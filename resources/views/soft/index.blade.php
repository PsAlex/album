@extends('layout.app')
@section('title')
soft-
@endsection
@section('link')
@endsection
@section('content')
@if(Auth::user())
<div class="col-md-3">
    <div class="panel panel-default">
        <div class="panel-heading">添加</div>
        <div class="panel-body">
            <form action="{{url('/softs')}}" method="POST" role="form">
                {!! csrf_field() !!}
                <div class="form-group">
                    <lable class="control-label">名称</lable>
                    <input type="text" class="form-control input-sm" required name="name" >
                </div>
                <div class="form-group">
                    <lable class="control-label">说明</lable>
                    <input type="text" class="form-control input-sm" required name="explain" autocomplete="off">
                </div>
                <div class="form-group">
                    <lable class="control-label">文件保存位置</lable>
                    <input type="text" class="form-control input-sm"  required autocomplete="off" name="download_href">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-sm btn-primary pull-right">新 建</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
<div class="{{Auth::user()? 'col-md-9':'com-md-12'}}">
    <table class="table table-responsive text-center">
        <thead>
            <tr>
                <td>
                    <form action="{{url('/softs?s=')}}" method="get" class="col-md-3 pull-right"><input
                        class="form-control"
                        name="s" autofocus autocomplete="off"
                        placeholder="软件搜索输入...">
                    </form>
                </td>
            </tr>
        </thead>
        <tbody>
            @if(sizeof($softs))
            @foreach($softs as $soft)
            <tr>
                <td>
                    <div class="col-md-12">
                        <div class ="col-md-6">{{$soft->name}}</div>
                        <div class ="col-md-6">{{$soft->explain}} </div>
                        <div class ="col-md-12">{{$soft->download_href}}</div>
                        @if(Auth::user())
                        <div class="col-md-12">
                            <a  class="role-btn col-md-4"><span class="glyphicon glyphicon-edit text-success"  data-toggle="modal"data-target="#edit" data-url="{{url('/softs/'.$soft->id)}}" aria-hidden="true">编辑</span></a>
                            &nbsp&nbsp&nbsp&nbsp
                            <a class="role-btn col-md-4"  data-toggle="modal" data-target="#delete" data-url="{{url('/softs/'.$soft->id)}}"><span class="glyphicon glyphicon-remove text-danger" aria-hidden="true">删除</span></a>
                        </div>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="5">未找到匹配记录</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5">
                    <nav class="text-center">{!! $softs->appends(['sort'=>$s])->render() !!} </nav>
                </td>
            </tr>
        </tfoot>
    </table>
</div>　
@include('layout.model.delete',['modal_title'=>'删除','modal_body'=>'确定要删除该条数据？'])
@include('layout.model.soft',['modal_title'=>'编辑','method'=>'put'])
@endsection
@section('script')
<script type="text/javascript">
    $('#edit').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var url    = button.data('url');
        var modal  = $(this);
        $.ajax({
            url: url+'/edit/',
            type: "get",
            async: true,
            dataType: "json",
            success: function (data) {
                modal.find("input[name='name']").attr('value', data.json_str.name);
                modal.find("input[name='explain']").attr('value', data.json_str.explain);
                modal.find("input[name='download_href']").attr('value', data.json_str.download_href);
            }
        });
        modal.find('form').attr('action', url);
    });
</script>
@endsection
　