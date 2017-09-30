@extends('layout.app')
@section('title')

        注册

@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">注册</div>
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

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register') }}">
<br/>
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label class="col-md-4 control-label">名 字</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" required placeholder="输入你的名字..." value="{{ old('name') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">邮 箱</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" required placeholder="输入你的邮箱...（登录名）" value="{{ old('email') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">密 码</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" required placeholder="输入密码..." name="password">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">确认密码</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" required placeholder="再次输入密码..." name="password_confirmation">
                            </div>
                        </div>
                         

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    注 册
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
