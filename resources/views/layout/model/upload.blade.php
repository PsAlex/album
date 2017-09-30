<!-- Modal -->

<div class="modal-dialog" >
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
				aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">{{$modal_title}}</h4>
			</div>

			<div class="modal-body text-center">
				<h3>{{$album->title}}</h3>
				{!! $method ?'<input type ="hidden" name="_method" value="'.$method.'">':'' !!}
				<div id="uploader" class="webuploader-container">
					<!--用来存放文件信息-->

					<div id="thelist" class="uploader-list jumbotron"> 拖拽文件到这里 …
					</div>
					<div id="html"></div>
					<div class="btns">
						<button id="ctlBtn" class="btn btn-default">开始上传</button>
					</div>


				</div>



			</div>
			<div class="modal-footer">
				{!! $album->path? '<div class="alert alert-warning">已经存在文件！确定上传覆盖？</div>':''!!}
			</div>

		</div>
	</div>
