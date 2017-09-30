@extends('layout.app')
@section('title')
home-
@endsection
@section('link')
<link rel="stylesheet" type="text/css" href="{{ asset('tag/jquery.tag-editor.css') }}">
@endsection
@section('content')
<div class="container">
	@if (checkPerm('albums.store'))
	<button class="btn btn-primary" data-toggle="modal" data-target="#create"  data-url="{{ asset('albums') }}"><span class="glyphicon glyphicon-folder-open" aria-hidden="true" ></span></button>
	<hr>
	@endif
	<div class="row">
		@if (sizeof($albums)>0)
		<div class="blog-masonry masonry-true">
			@foreach ($albums as $album)
			<div class="post-masonry col-md-4 col-sm-6">
				<div class="panel panel-default">
					<div class="panel-heading text-center"><a href="{{ asset('albums/'.$album->id) }}">{{$album->title}}</a></div>
					<div class="panel-body">
						@if (sizeof($album->photos)>0)
						<div class="text-center">
							<a href="{{ asset('albums/'.$album->id) }}" >
								<img src="{{asset($album->photos->first()->path_thumb)}}" class="img-thumbnail">
							</a>
						</div>
						@endif
						<div>
							<p>&nbsp&nbsp&nbsp&nbsp{{$album->description}}</p>
						</div>
					</div>
					<div class="panel-footer">
						@if (checkPerm('file.down'))
						<a class="role-btn col-md-4" href="{{ url('upload/'.$album->id) }}"><span class="glyphicon glyphicon-cloud-download" aria-hidden="true">下载</span></a>
						@endif
						@if (checkPerm('albums.update'))
						<a  class="role-btn col-md-4"><span class="glyphicon glyphicon-edit text-success"  data-toggle="modal" data-target="#edit" data-url="{{ asset('albums/'.$album->id) }}" aria-hidden="true">编辑</span></a>
						@endif
						@if (checkPerm('albums.destroy'))
						<a class="role-btn col-md-4"  data-toggle="modal" data-target="#delete" data-url="{{url('/albums/'.$album->id)}}"><span class="glyphicon glyphicon-remove text-danger" aria-hidden="true">删除</span></a>
						@endif
						<hr>
						<p>标 签:
							@if (sizeof(count($album->tag))>0)
							@for($i=0;$i<count($album->tag);$i++)
							<a href="{{ url('/?wd='.$album->tag[$i]) }}">{{$album->tag[$i]}}</a>
							@endfor
							@endif
						</p>
						<p>
							更新时间: {{date("Y-m-d",strtotime($album->updated_at))}}
						</p>
					</div>
				</div>
			</div>
			@endforeach
		</div>
		@endif
	</div>
	<nav class="text-center">
		<hr>
		{!!$albums->appends(['sort'=>$s])->render() !!}
	</nav>
</div>
@if (checkPerm('albums.destroy'))
@include('layout.model.delete', ['modal_title'=>'删除'])
@endif
@if (checkPerm('albums.store'))
<div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	@include('layout.model.album', ['modal_title'=>'新建','method'=>''])
</div>
@endif
@if (checkPerm('albums.update'))
<!--edit-->
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	@include('layout.model.album', ['modal_title'=>'编辑','method'=>'put'])
</div>
@endif
@endsection
@section('script')
<script type="text/javascript" src="{{ asset('js/min/plugins.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/min/main.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('tag/jquery.tag-editor.min.js') }}"></script>
<script type="text/javascript">
	@if (checkPerm('albums.store'))
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
	@endif
	@if (checkPerm('albums.update'))
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
	@endif
	@if (checkPerm('albums.store'))
	$('#edit,#create').on('hide.bs.modal', function (event) {
		window.location.reload();
	});
	@endif
</script>
@endsection