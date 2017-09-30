@extends('layout.app')
@section('title')
        login
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">登录</div>
                    <br>
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/login') }}">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label class="col-md-4 control-label">邮 箱</label>
                                <div class="col-md-6">
                                    <input type="email" autofocus class="form-control" name="email" placeholder="输入邮箱地址..." value="{{ old('email') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">密 码</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" placeholder="输入密码" name="password">
                                </div>
                            </div>

                            {{--<div class="form-group">--}}
                                {{--<div class="col-md-6 col-md-offset-4">--}}
                                    {{--<div class="checkbox">--}}
                                        {{--<label>--}}
                                            {{--<input type="checkbox" name="remember">记住我？--}}
                                        {{--</label>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-8">
                                    <button type="submit" class="btn btn-primary">登 录</button>

                                   
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
