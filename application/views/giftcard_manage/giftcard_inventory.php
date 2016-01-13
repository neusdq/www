<!-- datatables -->
<link rel="stylesheet" href="<?php echo RES; ?>lib/datatables/extras/TableTools/media/css/TableTools.css">
<link rel="stylesheet" href="<?php echo RES; ?>/common/common.css" />
<?php $this->load->view('shared/upload-file-css'); ?>
<?php $this->load->view('shared/alert'); ?>

<div class="row">
    <div class="col-sm-12 col-md-12">
        <h3 class="heading">礼品卡库</h3>
        <div class="w-box-header">
            <div class="pull-left sort-disabled margin-left-2">
                <input name="s_code" class="input-medium form-control" placeholder="卡号" type="text">
            </div>
            <div class="pull-left sort-disabled margin-left-2">
                <select name="s_status" class="select-medium form-control">
                    <option value="0">状态</option>
                    <option value="1">已开卡</option>
                    <option value="2">未开卡</option>
                    <option value="3">已兑换</option>
                    <option value="5">已退卡</option>
                </select>
            </div>
            <div class="pull-left sort-disabled margin-left-2">
                <input name="s_scode" class="input-medium form-control" placeholder="开始号码" type="text">
            </div>
            <div class="pull-left sort-disabled margin-left-2">
                <input name="s_ecode" class="input-medium form-control" placeholder="结束号码" type="text">
            </div>
            <div class="pull-left sort-disabled margin-left-2">
                <input name="s_date" class="input-medium form-control" placeholder="导入/生产时间" type="text">
            </div>
            <div class="pull-left sort-disabled margin-left-6">
                <button class="btn btn-success label search">查询</button>
            </div>
        </div>
        <div class="empty"></div>
        <div class="w-box-header">
            <div class="pull-left sort-disabled">
                <a class="btn btn-success label" id="down-giftcard">导出</a>
            </div>
            <div class="pull-left sort-disabled margin-left-2">
                <a class="btn btn-success label" id="create-giftcard">生成</a>
            </div>
        </div>
        <table class="table table-striped table-bordered dTableR" id="giftcard-tb">
            <thead>
                <tr>
                    <th class="center">卡号</th>
                    <th class="center">密码</th>
                    <th class="center">状态</th>
                    <th class="center">生成时间</th>
                </tr>
            </thead>
            <tbody class="center">

            </tbody>        
        </table>
    </div>
</div>

<!---------新建弹层---------->
<div class="modal fade" id="create-giftcard-modal">
    <div class="modal-dialog">
        <div class="modal-content" id="modal-max-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title">生产礼卡片</h3>
            </div>
            <div class="modal-body">
                <table class="table table-condensed table-striped">
                    <tbody>
                        <tr>
                            <td class="center">号段</td>
                            <td>
                                <input name="a_scode" type="text" class="form-control" placeholder="开始号段">
                            </td>
                            <td class="center">
                                ------
                            </td>
                            <td>
                                <input name="a_ecode" type="text" class="form-control" placeholder="结束号段">
                            </td>
                        </tr>
                        <tr>
                            <td class="alert-label-error center" colspan="4" id="crate-giftcard-error"></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="center">
                                <button type="button" class="btn btn-success" id="crate-giftcard-bnt">确认</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- datatable -->
<script src="<?php echo RES; ?>lib/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo RES; ?>lib/datatables/extras/Scroller/media/js/dataTables.scroller.min.js"></script>
<!-- datatable table tools -->
<script src="<?php echo RES; ?>lib/datatables/extras/TableTools/media/js/TableTools.min.js"></script>
<script src="<?php echo RES; ?>lib/datatables/extras/TableTools/media/js/ZeroClipboard.js"></script>
<!-- datatables bootstrap integration -->
<script src="<?php echo RES; ?>lib/datatables/jquery.dataTables.bootstrap.min.js"></script>
<!-- datatable functions -->
<script src="<?php echo RES; ?>js/pages/gebo_datatables.js"></script>
<!-- tables functions -->
<script src="<?php echo RES; ?>js/pages/gebo_tables.js"></script>

<?php $this->load->view('shared/upload-file'); ?>
<?php $this->load->view('shared/alert-upload'); ?>

<script src="<?php echo RES; ?>giftcard/giftcard_inventory.js"></script>

