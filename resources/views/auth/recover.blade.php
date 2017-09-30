@extends('layout.app')
@section('title')

        密码找回

@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">密码找回</div>
                    <div class="panel-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> 你的输入有一些问题...<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form class="form-horizontal" role="form" method="POST" action="{{ url('recover-password') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">



                            <div class="form-group">
                                <label class="col-md-4 control-label">邮 箱</label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="输入邮箱地址...">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">新密码</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password" required placeholder="输入新密码...">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">确认密码</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password_confirmation"  required placeholder="确认密码...">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">问 题</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="question"  required placeholder="输入你的问题...">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">答 案</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="answer" required placeholder="输入你的答案...">
                                </div>
                            </div>



                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        找 回
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection