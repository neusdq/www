<!-- datatables -->
<link rel="stylesheet" href="<?php echo RES; ?>lib/datatables/extras/TableTools/media/css/TableTools.css">
<link rel="stylesheet" href="<?php echo RES; ?>/common/common.css" />
<?php $this->load->view('shared/alert'); ?>

<div class="row">
    <div class="col-sm-12 col-md-12 col_lg_12">
        <h3 class="heading">兑换列表</h3>
        <div class="w-box-header col_lg_12">
            <div class="pull-left sort-disabled margin-left-1">
                <input name="s_customer_name" class="input-medium form-control" placeholder="客户名称" type="text">
            </div>
            <div class="pull-left sort-disabled margin-left-1">
                <input name="s_order_name" class="input-medium form-control" placeholder="商品" type="text">
            </div>
            <div class="pull-left sort-disabled margin-left-1">
                <input name="sales" class="input-medium form-control" placeholder="销售员" type="text">
            </div>
            <div class="pull-left sort-disabled margin-left-1">
                <select name="s_status" class="select-medium form-control">
                    <option value="0">付款状态</option>
                    <option value="1">未付款</option>
                    <option value="2">已付款</option>
                </select>
            </div>
            <!--
            <div class="pull-left sort-disabled margin-left-1 col-xs-1">
                <input name="a_start_date" id="a_deliver_date" class="datepicker" data-date-format="yy-mm-dd" placeholder="开始时间">
            </div>
            <div class="pull-left sort-disabled margin-left-2 col-xs-1">
                <input name="a_end_date" id="a_deliver_date" class="datepicker" data-date-format="yy-mm-dd" placeholder="结束时间">
            </div>
            !-->

            <div class="pull-left sort-disabled margin-left-2">
                <button class="btn btn-success label search">查询</button>
            </div>
        </div>
        <div class="w-box-header">
            <div class="pull-left sort-disabled">
                <a class="btn btn-success label" href="/media_manage/add_media">新建订单</a>
                <a class="btn btn-success label margin-left-2" id="stop-media">更改状态</a>               
            </div>
        </div>
        <div class="empty"></div>
        <table class="table table-striped table-bordered dTableR" id="orderlist_tb">
            <thead
                <tr>
                    <th class="table_checkbox center">
                        <input name="select_rows" class="select_rows" data-tableid="eorderlist_tb" type="checkbox">
                    </th>
                    <th class="center">交易时间</th>
                    <th class="center">销售员</th>
                    <th class="center">客户名称</th>
                    <th class="center">记录人</th>
                    <th class="center">商品</th>
                    <th class="center">总价格</th>
                    <th class="center">付款状态</th>
                    <th class="center">付款备注</th>
                    <th class="center">开卡备注</th>
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

<script src="<?php echo RES; ?>order/eorder_list.js"></script>




