<!-- Modal -->
<div class="modal fade" id="edit-self" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
					aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">{{$modal_title}}</h4>
				</div>
				<form class="form-horizontal" method="post" role="form">
					<div class="modal-body text-center">
						<div class="input-group col-md-12">{{Auth::user()->email}}</div>
						{{csrf_field()}}
						<br>
						<div class="input-group col-md-12">
							<span class="input-group-addon" id="sizing-addon1">名称</span>
							<input type="input" class="form-control" name="name" value="{{Auth::user()->name}}" 
							aria-describedby="sizing-addon1">
						</div>
						<br>
						<div class="input-group col-md-12">
							<span class="input-group-addon" id="sizing-addon1">密码</span>
							<input type="password" class="form-control" name="password"
							aria-describedby="sizing-addon1">
						</div>
						<br>
						<div class="input-group col-md-12">
							<span class="input-group-addon" id="sizing-addon1">确认密码</span>
							<input type="password" class="form-control" name="password_confirmation"
							aria-describedby="sizing-addon1">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
						<button type="submit" class="btn btn-primary">修改</button>
					</div>
				</form>
			</div>
		</div>
	</div>