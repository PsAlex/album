<!-- Modal -->

<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
				aria-hidden="true">&times;</span>
			</button>
			<h4 class="modal-title" id="myModalLabel">{{$modal_title}}</h4>
		</div>
		<form class="form-horizontal" method="post" role="form"  enctype="multipart/form-data">
			<div class="modal-body">

				<br>
				{{csrf_field()}}
				{!! $method ?'<input type ="hidden" name="_method" value="'.$method.'">':'' !!}

					<input type="file" dir=rtl   name="image" class="">

				<br>
				<div class="input-group col-md-12">
					<span class="input-group-addon" id="sizing-addon1">标题</span>
					<input type="input" class="form-control" name="title"
					aria-describedby="sizing-addon1">
				</div>
				<br>
				<div class="input-group col-md-12">
					<span class="input-group-addon input-sm" id="sizing-addon1">描述</span>
					<textarea class="form-control" style="min-height: 70px" name="description"></textarea>
				</div>
				<input type="hidden" name="album_id" value="{{$album->id}}">
				<br>

				<div id="html"></div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
				<button type="submit" class="btn btn-primary">编辑</button>
			</div>
		</form>
	</div>
</div>

