<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')Ps</title>
    <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}"/>
    <link rel="stylesheet" href="{{asset('/css/css.css')}}">
    <style>
        body {
            padding-top: 70px;
        }
    </style>
    @yield('link')
    <!-- Fonts -->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body ondragstart="return false;">
    <!--nav -->
    <nav class="navbar navbar-default  navbar-fixed-top ">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/" style="font-family:'Viner Hand ITC';font-style: italic"> Ps</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li>
                    <a href="{{ url('/') }}">Home</a>
                </li>
                <li>
                    <a href="{{url('/softs')}}">软件查询</a>
                </li>
                @if(Auth::user())
                    <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                    aria-expanded="false">管理<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{url('/admin/users')}}">用户管理</a></li>
                        <li><a href="{{url('/admin/roles')}}">所有角色</a></li>
                        <li><a href="{{url('/admin/permissions')}}">权限管理</a></li>
                    </ul>
                </li>
                @endif
                
                <li><a href="http://192.168.30.2" target="_blank">归档</a></li>
                <li><a href="http://192.168.30.2:8081" target="_blank">论坛</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                    aria-expanded="false">经营 OA<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                       <li><a href="http://192.168.30.31:8080" target="_blank">经营</a></li>
                       <li><a href="http://192.168.30.31:8081" target="_blank">OA</a></li>
                   </ul>
               </li>
           </ul>
           <ul class="nav navbar-nav navbar-right">
            @if (Auth::guest())
            <li>
                <a href="{{ url('/auth/login') }}">登 录</a>
            </li>
            <li>
                <a href="{{ url('/auth/register') }}">注 册</a>
            </li>
            @else
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    {{ Auth::user()->name }}
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" role="menu">
                    <li>
                        <a data-toggle="modal" class="role-btn" data-target="#edit-self" data-url="{{ url('user/profile') }}">修改资料</a>
                    </li>
                    <li>
                        <a href="{{ url('/auth/logout') }}">退 出</a>
                    </li>
                </ul>
            </li>
            @endif
        </ul>
        <form class="navbar-form navbar-right" role="search" method="get" action="{{url('?wd=')}}">
            <div class="form-group">
                <input type="text" class="form-control input-sm"  placeholder="搜索输入..." name="wd"></div>
            </form>
        </div>
    </div>
</nav>
<!--nav end-->
<!--container -->
<div class="container">
    @include('layout.info')
    @yield('content')
</div>
<!--container end-->
<!--footer-->
<footer class="footer">
    <div class="container">
        <div class="row footer-top">
            <hr>
            <br><br><br>
            <div class="row footer-bottom">
                <ul class="list-inline text-center">
                    <li>ps@admin.com</li>
                </ul>
            </div>
        </div>
    </div>
</footer>
@if (Auth::user())
@include('layout.model.profile', ['modal_title' => '修改资料'])
@endif

<!-- Scripts -->
<script src="{{asset('js/jquery.js')}}"></script>
<script src="{{asset('js/bootstrap.js')}}"></script>
<script type="text/javascript">
    $('#delete').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var url = button.data('url');
        var modal = $(this);
        var role = button.data('role');
        modal.find('form').attr('action', url);
    });
    $('#edit-self').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var url = button.data('url');
        var modal = $(this);
        var role = button.data('role');
        modal.find('form').attr('action', url);
    });    
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    })
</script>
@yield('script')
</body>
</html>