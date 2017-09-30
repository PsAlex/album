<!-- Modal -->
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{$modal_title}}</h4>
                </div>
                <form class="form-horizontal" method="post" role="form">
                    <div class="modal-body">
                        {{csrf_field()}}
                        <input type="hidden" name="_method" value="put">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="名称" name="name"
                            aria-describedby="sizing-addon1">
                            <span class="input-group-addon" id="sizing-addon1">名称</span>
                        </div>
                        <br>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="显示名称" name="display_name"
                            aria-describedby="sizing-addon2">
                            <span class="input-group-addon " id="sizing-addon2">显示名称</span>
                        </div>
                        <br>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="描述" name="description"
                            aria-describedby="sizing-addon2">
                            <span class="input-group-addon" id="sizing-addon3">描述</span>
                        </div>
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
    </div>