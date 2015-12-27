<!-- datatables -->
<link rel="stylesheet" href="<?php echo RES; ?>lib/datatables/extras/TableTools/media/css/TableTools.css">
<link rel="stylesheet" href="<?php echo RES; ?>/common/common.css" />
<?php $this->load->view('shared/upload-file-css'); ?>
<?php $this->load->view('shared/alert'); ?>

<div class="row">
    <div class="col-sm-12 col-md-12">
        <h3 class="heading">退卡管理</h3>
        <div class="w-box-header">
            <div class="pull-left sort-disabled margin-left-2">
                <input name="s_sales" class="input-medium form-control" placeholder="销售员" type="text">
            </div>
            <div class="pull-left sort-disabled margin-left-2">
                <input name="s_sdate" class="input-medium form-control" placeholder="开始时间" type="text">
            </div>
             <div class="pull-left sort-disabled margin-left-2">
                <input name="s_edate" class="input-medium form-control" placeholder="结束时间" type="text">
            </div>
            <div class="pull-left sort-disabled margin-left-6">
                <button class="btn btn-success label search">查询</button>
            </div>
        </div>
        <div class="empty"></div>
        <div class="w-box-header">
            <div class="pull-left sort-disabled">
                <a class="btn btn-success label" href="/giftcard_manage/do_cancel_giftcard">退卡</a>
            </div>
        </div>
        <table class="table table-striped table-bordered dTableR" id="giftcard-order_tb">
            <thead>
                <tr>
                    <th class="table_checkbox center">
                        <input name="select_rows" class="select_rows" data-tableid="cancel_giftcard-tb" type="checkbox">
                    </th>
                    <th class="center">退卡时间</th>
                    <th class="center">销售员</th>
                    <th class="center">客户</th>
                    <th class="center">最终用户</th>
                    <th class="center">记录人</th>
                    <th class="center">退卡数量</th>
                    <th class="center">备注</th>
                    <th class="center" width="200">操&nbsp;&nbsp;&nbsp;&nbsp;作</th>
                </tr>
            </thead>
            <tbody class="center">

            </tbody>        
        </table>
    </div>
</div>

<!---------编辑弹层---------->
<div class="modal fade" id="edit-cancel-giftcard-modal">
    <div class="modal-dialog">
        <div class="modal-content" id="modal-max-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title">修改</h3>
            </div>
            <div class="modal-body">
                <table class="table table-condensed table-striped">
                    <tbody>
                        <tr>
                            <td class="text-left" style="vertical-align: middle;width: 80px;">销售员</td>
                            <td>
                                <input name="e_id" class="form-control" type="hidden">
                                <select name="e_sales" data-placeholder="选择销售员" class="chzn_a form-control">
                                    <?php $i = 0; ?>
                                    <?php foreach ($sales as $v): ?>
                                        <option value="<?php echo $v['id']; ?>" <?php echo $i == 0 ? 'selected="selected"' : ''; ?>>
                                            <?php echo $v['nick_name'] ? $v['nick_name'] : $v['user_name']; ?>
                                        </option>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td class="text-left" style="vertical-align: middle;width: 80px;">退卡日期</td>
                            <td>
                               <span name="e_canceldate" class="form-control"></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left" style="vertical-align: middle;width: 80px;">客户名称</td>
                            <td colspan="3">
                                <select name="e_customer" data-placeholder="选择客户" class="chzn_a form-control">
                                    <option value="">请选择</option>
                                    <?php foreach ($customer as $v): ?>
                                        <option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left" style="vertical-align: middle;width: 80px;">最终用户</td>
                            <td colspan="3">
                                <input name="e_enduser" class="form-control" type="text">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left" style="vertical-align: middle;width: 80px;">联系人</td>
                            <td>
                                <input name="e_contact_person" class=" form-control" type="text">
                            </td>
                            <td class="text-left" style="vertical-align: middle;">电话</td>
                            <td>
                                <input name="e_phone" class=" form-control" type="text">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left" style="vertical-align: middle;width: 80px;">地址</td>
                            <td colspan="3">
                                <input name="e_address" class="form-control" type="text">
                            </td>
                        </tr>
                        
                        <tr>
                            <td class="text-left" style="vertical-align: middle;width: 80px;">备注</td>
                            <td colspan="3">
                                <textarea name="e_remark" cols="6" rows="3" class="form-control"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" class="center">
                                <button type="button" class="btn btn-success" id="edit-cancel-giftcard-bnt">保存</button>
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

<script src="<?php echo RES; ?>giftcard/giftcard_cancel_list.js"></script>

<script>
    var salesArr = <?php echo json_encode($sales); ?>;
    var customerArr = <?php echo json_encode($customer); ?>;
</script>



