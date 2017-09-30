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
                        <input type="hidden" name="_method" value="{{$method}}">
                        <div class="input-group">
                            <input type="text" class="form-control"  name="name" autocomplete="off"
                            aria-describedby="sizing-addon1">
                            <span class="input-group-addon" id="sizing-addon1">名称</span>
                        </div>
                        <br>
                        <div class="input-group">
                            <input type="text" class="form-control" name="explain" autocomplete="off"
                            aria-describedby="sizing-addon2">
                            <span class="input-group-addon " id="sizing-addon2" >说明</span>
                        </div>
                        <br>
                        <div class="input-group">
                            <input type="text" class="form-control" name="download_href"
                            aria-describedby="sizing-addon2" autocomplete="off">
                            <span class="input-group-addon" id="sizing-addon3" >文件保存位置</span>
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