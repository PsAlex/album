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
                        <div id="email" class="text-center"></div>
                        <br>
                        {{csrf_field()}}
                        <input type="hidden" name="_method" value="{{$method}}">
                        <div class="input-group">
                            <span class="input-group-addon" id="sizing-addon1">密码：</span>
                            <input type="password" class="form-control" name="password"
                            aria-describedby="sizing-addon1">

                        </div>
                        <br>
                        <div id="html"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关 闭</button>
                        <button type="submit" class="btn btn-primary">编 辑</button>
                    </div>
                </form>
            </div>
        </div>
    </div>