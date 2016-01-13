<!-- datatables -->
<link rel="stylesheet" href="<?php echo RES; ?>lib/datatables/extras/TableTools/media/css/TableTools.css">
<link rel="stylesheet" href="<?php echo RES; ?>/common/common.css" />
<?php $this->load->view('shared/alert'); ?>

<div class="row">
    <div class="col-sm-12 col-md-12 col_lg_12">
        <h3 class="heading">退换货</h3>
        <div class="w-box-header col_lg_12">
            <div class="pull-left sort-disabled margin-left-1">
                <input name="order_id" class="input-medium form-control" placeholder="关联订单" type="text">
            </div>
            <div class="pull-left sort-disabled margin-left-1">
                <input name="customer_name" class="input-medium form-control" placeholder="客户名称" type="text">
            </div>
            <div class="pull-left sort-disabled margin-left-1">
                <select name="type" class="select-medium form-control">
                    <option value="0">类型</option>
                    <option value="1">退货</option>
                    <option value="2">换货</option>
                </select>
            </div>
            <div class="pull-left sort-disabled margin-left-1">
                <select name="status" class="select-medium form-control">
                    <option value="0">状态</option>
                    <option value="1">未审核</option>
                    <option value="2">未入库</option>
                    <option value="3">未出库</option>
                    <option value="4">已退货</option>
                    <option value="5">已换货</option>
                    <option value="6">审核未通过</option>
                </select>
            </div>

            <div class="pull-left sort-disabled margin-left-2">
                <button class="btn btn-success label search">查询</button>
            </div>
        </div>
        <div class="w-box-header">
            <div class="pull-left sort-disabled">
                <a class="btn btn-success label" href="/order_manage/add_return_order">退货</a>
                <a class="btn btn-success label margin-left-2" href="/order_manage/add_exchange_order">换货</a>
                <a class="btn btn-success label" id="update-status-a">更换状态</a>
            </div>
        </div>
        <div class="empty"></div>
        <table class="table table-striped table-bordered dTableR" id="rorderlist_tb">
            <thead
                <tr>
                    <th class="table_checkbox center">
                        <input name="select_rows" class="select_rows" data-tableid="rorderlist_tb" type="checkbox">
                    </th>
                    <th class="center">关联订单</th>
                    <th class="center">客户名称</th>
                    <th class="center">联系电话</th>
                    <th class="center">记录人</th>
                    <th class="center">类型</th>
                    <th class="center">状态</th>
                    <th class="center">退款金额</th>
                    <th class="center">操作时间</th>
                    <th class="center">备注</th>
                    <th class="center">操作</th>
                </tr>
            </thead>
            <tbody class="center">

            </tbody>        
        </table>
    </div> 
</div>

<div class="modal fade" id="update-order-status-modal">
    <div class="modal-dialog">
        <div class="modal-content" id="modal-max-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title">修改状态</h3>
            </div>
            <div class="modal-body">
                <table class="table table-condensed table-striped">
                    <tbody>
                        <tr>
                            <td class="center">订单状态</td>
                            <td>
                                <select name="e_status" class="select-medium form-control">
                                    <option value="0" >已作废</option>
                                    <option value="1" selected="selected">未审核</option>
                                    <option value="2">未发货</option>
                                    <option value="3">已发货</option>
                                    <option value="4">已送达</option>
                                </select>
                            </td>
                            <td class="alert-label-error center" id="e-status-error"></td>
                        </tr>
                        <tr>
                            <td class="center">备注</td>
                            <td>
                                <textarea name="e_remark" cols="6" rows="3" class="form-control"></textarea>
                            </td>
                            <td class="alert-label-error center" ></td>
                        </tr>
                        <tr>
                            <td class="alert-label-error center" id="e-remark-error" colspan="3" style="text-align: center;"></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="center">
                                <button type="button" class="btn btn-success" id="update-status-bnt">确认</button>
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

<script src="<?php echo RES; ?>order/rorder_list.js"></script>




