<!-- Modal -->
<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                        <input type="hidden" name="_method" value="delete">
                        <p>确定删除该条数据？</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="right" title="谨慎操作">删除</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
