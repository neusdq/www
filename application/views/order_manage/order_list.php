<!-- datatables -->
<link rel="stylesheet" href="<?php echo RES; ?>lib/datatables/extras/TableTools/media/css/TableTools.css">
<link rel="stylesheet" href="<?php echo RES; ?>/common/common.css" />
<?php $this->load->view('shared/alert'); ?>

<div class="row">
    <div class="col-sm-12 col-md-12">
        <h3 class="heading">兑换列表</h3>
        <div class="w-box-header">
            <div class="pull-left sort-disabled margin-left-2">
                <input name="s_id" class="input-medium form-control" placeholder="订单号" type="text">
            </div>
            <div class="pull-left sort-disabled margin-left-2">
                <input name="s_deliver_num" class="input-medium form-control" placeholder="快递单号" type="text">
            </div>
            <div class="pull-left sort-disabled margin-left-2">
                <input name="s_customer_name" class="input-medium form-control" placeholder="用户名" type="text">
            </div>
            <div class="pull-left sort-disabled margin-left-2">
                <input name="s_phone" class="input-medium form-control" placeholder="手机号" type="text">
            </div>
            <div class="pull-left sort-disabled margin-left-2">
                <input name="s_book_id" class="input-medium form-control" placeholder="全部礼册" type="text">
            </div>
            <div class="pull-left sort-disabled margin-left-2">
                <select name="s_status" class="select-medium form-control">
                    <option value="0">订单状态</option>
                    <option value="1">未审核</option>
                    <option value="2">已审核</option>
                </select>
            </div>
            <div class="pull-left sort-disabled margin-left-1">
                <select name="s_order_source" class="select-medium form-control">
                    <option value="0">订单来源</option>
                    <option value="1">电话</option>
                    <option value="2">微信</option>
                    <option value="3">蓝卡官网</option>
                </select>
            </div>
            <div class="pull-left sort-disabled margin-left-6">
                <button class="btn btn-success label search">查询</button>
            </div>
        </div>
        <div class="empty"></div>
        <div class="w-box-header">
            <div class="pull-left sort-disabled">
                <a class="btn btn-success label" href="/customer_manage/add_customer">更换状态</a>
            </div>
        </div>
        <table class="table table-striped table-bordered dTableR" id="orderlist_tb">
            <thead
                <tr>
                    <th class="table_checkbox center">
                        <input name="select_rows" class="select_rows" data-tableid="orderlist_tb" type="checkbox">
                    </th>
                    <th class="center">订单编号</th>
                    <th class="center">快递单号</th>
                    <th class="center">快递公司</th>
                    <th class="center">商品名称</th>
                    <th class="center">收件人</th>
                    <th class="center">手机号</th>
                    <th class="center">发货地址</th>
                    <th class="center">状态</th>
                    <th class="center">订单来源</th>
                    <th class="center">操作</th>
                </tr>
            </thead>
            <tbody class="center">

            </tbody>        
        </table>
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

<script src="<?php echo RES; ?>order/order_list.js"></script>




