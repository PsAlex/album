<!-- Modal -->

<div class="modal-dialog" role="document">
	<div class="modal-content">
		<form class="form-horizontal" method="post" role="form" >
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
					aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="myModalLabel"><a class="role-btn" >{{$modal_title}}</a> </h4>
			</div>

			<div class="modal-body">
				<br>
				{{csrf_field()}}
				{!! $method ?'<input type ="hidden" name="_method" value="'.$method.'">':'' !!}
				<div class="input-group">
					<span class="input-group-addon" id="sizing-addon1">标题</span>
					<input type="input" class="form-control" name="title"
					aria-describedby="sizing-addon1">
				</div>
				<br>
				<div class="input-group">
					<span class="input-group-addon input-sm" id="sizing-addon1">描述</span>
					{{-- <input type="input" class="form-control" name="description"
					aria-describedby="sizing-addon1"> --}}
					<textarea class="form-control" name="description" aria-describedby="sizing-addon1" style="min-height: 80px"></textarea>
				</div>
				<br>
				<div class="input-group tag">
					<span class="input-group-addon" id="sizing-addon1" >标签</span>
					<input type="input" name="tag" aria-describedby="sizing-addon1">
				</div>
				<br>
				<div id="html"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
				<button type="submit" class="btn btn-primary">编辑</button>
			</div>

		</div>
	</form>
</div>

