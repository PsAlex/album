@extends('layout.app')
@section('title')
photo-
@endsection
@section('link')
<link rel="stylesheet" type="text/css" href="{{ asset('tag/jquery.tag-editor.css') }}">
<link href="{{ asset('/fancybox/jquery.fancybox.css') }}?v=2.15" rel="stylesheet" type="text/css"
media="screen">
<link rel="stylesheet" type="text/css"
href="{{asset('/fancybox/helpers/jquery.fancybox-buttons.css?v=1.0.5')}}"/>
<link rel="stylesheet" href="{{asset('fileinput/css/fileinput.css')}}">
<link rel="stylesheet" href="{{asset('fileinput/css/fileinput-rtl.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('tag/jquery.tag-editor.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('webuploader/webuploader.css') }}">
@endsection
@section('content')
<h1 class="text-center"><p>{{$album->title}}</p></h1>
<div>
	@if (checkPerm('photos.store'))
	<button  class="btn btn-primary" data-toggle="modal" data-target="#create-photo"  data-url="{{ asset('photos') }}"><span class="glyphicon glyphicon-picture" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="新建图片"></span></button>
	@endif
	@if (checkPerm('albums.update'))
	<button  class="btn btn-primary" data-toggle="modal" data-target="#edit"  data-url="{{ asset('albums/'.$album->id) }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="编辑图集"></span></button>
	@endif
	@if (checkPerm('file.down'))
	<a  class="btn btn-primary" href="{{ url('upload/'.$album->id) }}" ><span class="glyphicon glyphicon-flash" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="下载图集"></span></a>
	@endif
	@if (checkPerm('upload.store'))
	<button  class="btn btn-primary" data-toggle="modal" data-target="#upload"  ><span class="glyphicon glyphicon-upload" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="上传图集"></span></button>
	@endif
	<div class="pull-right">
		@if (checkPerm('albums.store'))
		<button class="btn btn-primary" data-toggle="modal" data-target="#create"  data-url="{{ asset('albums') }}"><span class="glyphicon glyphicon-folder-open" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="新建图集" ></span></button>
		@endif
		@if (checkPerm('albums.destroy'))
		<button  class="btn btn-danger" data-toggle="modal" data-target="#delete"  data-url="{{url('/albums/'.$album->id)}}"><span class="glyphicon glyphicon-remove" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="删除图集"></span></button>
		@endif
	</div>
	<div id="progress">
		<br>
	</div>
	<hr>
</div>
<div class="row">
	<div class=" col-md-12"><p class="text-muted col-md-8 col-md-offset-2 ">&nbsp&nbsp&nbsp&nbsp{{$album->description}}</p>
		<p class="col-md-2">
			标签：
			@if (sizeof(count($album->tag))>0)
			@for($i=0;$i<count($album->tag);$i++)
			<a href="{{ url('/?wd='.$album->tag[$i]) }}">{{$album->tag[$i]}}</a>
			@endfor
			@endif
		</p>
	</div>
	@if (sizeof($album->photos)>0)
	<div class="col-md-12">
		<div class="blog-masonry masonry-true">
			@foreach ($album->photos as $photo)
			<div class="post-masonry col-md-4 col-sm-6">
				<div class="thumbnail">
					<div class="text-center">
						<a class="fancybox" rel="fancybox-thumb" href="{{ $photo->path }}" title="{{$photo->title}}">
							<img
							src="{{ asset($photo->path_thumb) }}">
						</a>
					</div>
					<div class="caption">
						<h3 class="text-center">{{$photo->title}}</h3>
						<p>&nbsp&nbsp&nbsp&nbsp{{$photo->description}}</p>
						<p class="pull-right">
							@if (checkPerm('photos.update'))
							<a  class="role-btn col-md-4" data-toggle="modal" data-target="#edit-photo" data-url="{{url('photos/'.$photo->id)}}"><span class="glyphicon glyphicon-edit text-success" aria-hidden="true">edit</span></a>
							@endif
							@if (checkPerm('photos.destroy'))
							<a class="role-btn col-md-4"  data-toggle="modal" data-target="#delete" data-url="{{url('photos/'.$photo->id)}}"><span class="glyphicon glyphicon-remove text-danger" aria-hidden="true">delete</span></a>
							@endif
						</p>
						<br>
					</div>
				</div>
			</div>
			@endforeach
		</div>
	</div>
	@else
	<div class="alert alert-danger">
		<p>空图集 ,请先创建图片.</p>
	</div>
	@endif
</div>
@include('layout.model.delete', ['modal_title'=>'删除'])
<!--create album-->
<div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	@include('layout.model.album', ['modal_title'=>'新建图集','method'=>''])
</div>
<!--edit album-->
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	@include('layout.model.album', ['modal_title'=>'编辑图集','method'=>'put'])
</div>
<div class="modal fade" id="create-photo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	@include('layout.model.photo', ['modal_title'=>'创建图片','method'=>''])
</div>
<!--edit-->
<div class="modal fade" id="edit-photo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	@include('layout.model.photo', ['modal_title'=>'编辑图片','method'=>'put'])
</div>
<div class="modal fade" id="upload" tabindex="-1" role="dialog">
	@include('layout.model.upload', ['modal_title'=>'上传图集','method'=>''])
</div>
@endsection
@section('script')
<script src="{{asset('fancybox/jquery.mousewheel-3.0.6.pack.js')}}" type="text/javascript"></script>
<script src="{{asset('fancybox/jquery.fancybox.js?v=2.1.5')}}" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="{{asset('fancybox/jquery.fancybox.css?v=2.1.5')}}" media="screen"/>
<!-- Add Button helper (this is optional) -->
<link rel="stylesheet" type="text/css"
href="  {{asset('fancybox/helpers/jquery.fancybox-buttons.css?v=1.0.5')}}"/>
<script type="text/javascript" src="{{asset('fancybox/helpers/jquery.fancybox-buttons.js?v=1.0.5')}}"></script>
<!-- Add Thumbnail helper (this is optional) -->
<link rel="stylesheet" type="text/css" href="{{asset('fancybox/helpers/jquery.fancybox-thumbs.css?v=1.0.7')}}"/>
<script type="text/javascript" src="{{asset('fancybox/helpers/jquery.fancybox-thumbs.js?v=1.0.7')}}"></script>
{{-- webuplaoder --}}
<script type="text/javascript" src="{{ asset('webuploader/webuploader.min.js') }}"></script>
<script>
	$(".fancybox").fancybox({
		padding: 0,
		closeBtn: false,
		arrows: false,
		opacity:true,
		nextClick: true,
		titleShow:true,
		helpers: {
			title: {
				type : 'true'
			},
			thumbs: {
				width: 50,
				height: 50
			}
		}
	});
</script>
<!--图片流插件-->
<script type="text/javascript" src="{{ asset('js/min/plugins.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/min/main.min.js') }}"></script>
<script src="{{asset('fileinput/js/fileinput.js')}}" type="text/javascript"></script>
<script src="{{asset('fileinput/js/locales/zh.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('tag/jquery.tag-editor.min.js') }}"></script>
<script>
// ------------create photo
$('#create-photo').on('show.bs.modal',function(event){
	var button = $(event.relatedTarget);
	var url = button.data('url');
	var modal = $(this);
	modal.find('form').attr('action', url);
});
$('#edit-photo').on('show.bs.modal', function (event) {
	var button   = $(event.relatedTarget);
	var url      = button.data('url');
	var modal    = $(this);
	var json_tag = '';
	$.ajax({
		url: url+'/edit',
		type: "get",
		async: true,
		dataType: "json",
		success: function (data) {
			modal.find("input[name='title']").attr('value', data.json_str.title);
			modal.find("textarea[name='description']").text( data.json_str.description);
		}
	});
	modal.find('form').attr('action', url);
});
// ---------image upload
$('input[name="image"]').fileinput({
	language: "zh",
	maxFileSize:1024,
		showUpload: false, //是否显示上传按钮
		showCaption: true,//是否显示标题
		allowedFileExtensions: ["gif", "bmp", 'jpg','png','jpeg'],
		layoutTemplates:{
			// actionDelete:'',
			actionUpload:'',
			// actionZoom:''
		}
	});
// ----create album
$('#create').on('show.bs.modal',function(event){
	var button = $(event.relatedTarget);
	var url = button.data('url');
	var modal = $(this);
	modal.find('ul[class="tag-editor"]').remove();
	$('input[name="tag"]').tagEditor({
		'placeholder':'便签以回车结束'
	});
	modal.find('form').attr('action', url);
});
$('#edit').on('show.bs.modal', function (event) {
	var button   = $(event.relatedTarget);
	var url      = button.data('url');
	var modal    = $(this);
	var json_tag = '';
	$.ajax({
		url: url+'/edit',
		type: "get",
		async: true,
		dataType: "json",
		success: function (data) {
			modal.find('ul[class="tag-editor"]').remove();
			modal.find("input[name='title']").attr('value', data.json_str.title);
			modal.find("textarea[name='description']").text(data.json_str.description);
			modal.find('input[name="tag"]').attr('value', data.json_str.tag);
			if (data.json_str.tag!=null) {
				json_tag =data.json_str.tag;
			}
			$('input[name="tag"]').tagEditor({
				'placeholder':'便签以回车结束'
			});
		}
	});
	modal.find('form').attr('action', url);
});
$('#edit,#create').on('hide.bs.modal', function (event) {
	window.location.reload();
});

	// upload file
	var $ = jQuery,
	$list = $('#thelist'),
	$btn = $('#ctlBtn'),
	state = 'pending',
	uploader;
	uploader = WebUploader.create({
            // swf文件路径
            swf: '{{asset('/webuploader/Uploader.swf')}}',
            threads: 1,
            compress: !1,
            chunkRetry: 3,
            // 文件接收服务端。
            server: '{{asset(url('/upload'))}}',
            // 开起分片上传。
            chunked: true,
            chunkSize: 1024 * 1024 * 2,
            duplicate: true,
            fileNumLimit: 1,
            prepareNextFile: !0,
            dnd: "body",
            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick:'#picker',
            formData: {'_token': '{{csrf_token()}}', 'album_id': {{$album->id}} },
            // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
            resize: false,
            accept: {
            	title: 'winrar',
            	extensions: 'rar,zip,7z',
            },
            thumb:{
            	width: 110,
            	height: 110,
    // 图片质量，只有type为`image/jpeg`的时候才有效。
    // quality: 70,
    // 是否允许放大，如果想要生成小图的时候不失真，此选项应该设置为false.
    allowMagnify: true,
    // 是否允许裁剪。
    // crop: true,
    // 为空的话则保留原有图片格式。
    // 否则强制转换成指定的类型。
    // type: 'image/jpeg'
}
});

	uploader.on('beforeFileQueued', function () {
		uploader.reset();
	});
// 当有文件添加进来的时候
uploader.on('fileQueued', function (file) {
	$list.html('<div id="' + file.id + '" class="item">' +
		'<h4 class="info">' + file.name + "<br/> size:" + WebUploader.formatSize(file.size) + '</h4>' +
		'<p class="state">等待上传...</p>' +
		'</div>');
});
        // 文件上传过程中创建进度条实时显示。
        uploader.on('uploadProgress', function (file, percentage) {
        	var $li = $('#' + file.id+',#progress'),
        	$percent = $li.find('.progress .progress-bar');
            // 避免重复创建
            if (!$percent.length) {
            	$percent = $('<div class="progress progress-striped active">' +
            		'<div class="progress-bar" role="progressbar" style="width: 0%">' +
            		'</div>' +
            		'</div>').appendTo($li).find('.progress-bar');
            }
            $li.find('p.state').text('上传中');
            $percent.css('width',percentage * 100 + '%' );
            $percent.html((percentage* 100).toFixed(2)  + '%');
        });
        uploader.on('uploadSuccess', function (file, response) {
        	$('#' + file.id).find('p.state').text(response.message);
        	console.log(response.message);

        });
        uploader.on('uploadError', function (file, reason) {
        	console.log(reason);
        	$('#' + file.id+',#progress').find('p.state').text('上传出错'+reason.message);
        });
        uploader.on('uploadComplete', function (file) {
        	$('#' + file.id+',#progress').find('.progress').fadeOut();
        	$('#progress div').remove();
        });
        uploader.on('all', function (type) {
        	if (type === 'startUpload') {
        		state = 'uploading';
        	} else if (type === 'stopUpload') {
        		state = 'paused';
        	} else if (type === 'uploadFinished') {
        		state = 'done';
        	}
        	if (state === 'uploading') {
        		$btn.text('暂停上传');
        	} else {
        		$btn.text('开始上传');
        	}
        });
        $btn.on('click', function () {
        	if (state === 'uploading') {
        		uploader.stop(true);
        	} else {
        		uploader.upload();
        	}
        });
    </script>
    @endsection