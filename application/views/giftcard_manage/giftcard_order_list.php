<!-- datatables -->
<link rel="stylesheet" href="<?php echo RES; ?>lib/datatables/extras/TableTools/media/css/TableTools.css">
<link rel="stylesheet" href="<?php echo RES; ?>/common/common.css" />
<?php $this->load->view('shared/upload-file-css'); ?>
<?php $this->load->view('shared/alert'); ?>

<div class="row">
    <div class="col-sm-12 col-md-12">
        <h3 class="heading">礼品卡开卡管理</h3>
        <div class="w-box-header">
            <div class="pull-left sort-disabled margin-left-2">
                <input name="s_customer" class="input-medium form-control" placeholder="客户名称" type="text">
            </div>
            <div class="pull-left sort-disabled margin-left-2">
                <input name="s_giftbook" class="input-medium form-control" placeholder="礼册名称" type="text">
            </div>
            <div class="pull-left sort-disabled margin-left-2">
                <input name="s_sales" class="input-medium form-control" placeholder="销售员" type="text">
            </div>
            <div class="pull-left sort-disabled margin-left-2">
                <select name="s_paystatus" class="select-medium form-control">
                    <option value="0">付款状态</option>
                    <option value="1">已付款</option>
                    <option value="2">未付款</option>
                </select>
            </div>
            <div class="pull-left sort-disabled margin-left-6">
                <button class="btn btn-success label search">查询</button>
            </div>
        </div>
        <div class="empty"></div>
        <div class="w-box-header">
            <div class="pull-left sort-disabled">
                <a class="btn btn-success label" id="edit-pay-status">修改付款状态</a>
            </div>
        </div>
        <table class="table table-striped table-bordered dTableR" id="giftcard-order_tb">
            <thead>
                <tr>
                    <th class="table_checkbox center">
                        <input name="select_rows" class="select_rows" data-tableid="giftcard-order_tb" type="checkbox">
                    </th>
                    <th class="center">交易时间</th>
                    <th class="center">销售员</th>
                    <th class="center">客户名称</th>
                    <th class="center">记录人</th>
                    <th class="center">礼册</th>
                    <th class="center">总价格</th>
                    <th class="center">付款状态</th>
                    <th class="center">付款备注</th>
                    <th class="center">开卡备注</th>
                    <th class="center" width="200">操&nbsp;&nbsp;&nbsp;&nbsp;作</th>
                </tr>
            </thead>
            <tbody class="center">

            </tbody>        
        </table>
    </div>
</div>

<!---------修改付款状态弹层---------->
<div class="modal fade" id="update-giftcard-order-paystatus-modal">
    <div class="modal-dialog">
        <div class="modal-content" id="modal-max-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title">修改付款状态</h3>
            </div>
            <div class="modal-body">
                <table class="table table-condensed table-striped">
                    <tbody>
                        <tr>
                            <td class="center">付款状态</td>
                            <td>
                                <select name="e_paystatus" class="select-medium form-control">
                                    <option value="1" selected="selected">已付款</option>
                                    <option value="2">未付款</option>
                                </select>
                            </td>
                            <td class="alert-label-error center" id="paystatus-error"></td>
                        </tr>
                        <tr>
                            <td class="center">备注</td>
                            <td>
                                <textarea name="e_paystatus_remark" cols="6" rows="3" class="form-control"></textarea>
                            </td>
                            <td class="alert-label-error center" ></td>
                        </tr>
                        <tr>
                            <td class="alert-label-error center" id="e_paystatus_remark-error" colspan="3" style="text-align: center;"></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="center">
                                <button type="button" class="btn btn-success" id="update-giftcard-order-status-bnt">确认</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!---------二维码弹层---------->
<div class="modal fade" id="ewm-modal">
    <div class="modal-dialog">
        <div class="modal-content" id="modal-max-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title">二维码</h3>
            </div>
            <div class="modal-body">
                
            </div>
        </div>
    </div>
</div>

<!---------编辑弹层---------->
<div class="modal fade" id="edit-giftcard-order-modal">
    <div class="modal-dialog">
        <div class="modal-content" id="modal-max-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title">编辑</h3>
            </div>
            <div class="modal-body">
                <table class="table table-condensed table-striped">
                    <tbody>
                        <tr>
                            <td class="text-left" style="vertical-align: middle;width: 80px;">销售员</td>
                            <td>
                                <input name="e_orderid" class="form-control" type="hidden">
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
                            <td class="text-left" style="vertical-align: middle;width: 80px;">交易日期</td>
                            <td>
                               <span name="e_tradedate" class="form-control"></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left" style="vertical-align: middle;width: 80px;">客户名称</td>
                            <td colspan="3">
                                <select name="e_customer" data-placeholder="选择客户" class="chzn_a form-control">
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
                            <td class="text-left" style="vertical-align: middle;width: 80px;">微信模板</td>
                            <td colspan="3">
                                <select name="e_wechat" data-placeholder="选择微信模板" class="chzn_a form-control">
                                    <?php foreach ($wechat as $v): ?>
                                        <option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
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
                                <button type="button" class="btn btn-success" id="edit-giftcard-order-bnt">保存</button>
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

<script src="<?php echo RES; ?>giftcard/giftcard_order_list.js"></script>

<script>
    var customerArr = <?php echo json_encode($customer); ?>;
</script>

