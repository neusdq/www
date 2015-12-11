<!-- multiselect -->
<link rel="stylesheet" href="<?php echo RES; ?>lib/multi-select/css/multi-select.css" />
<!-- enhanced select -->
<link rel="stylesheet" href="<?php echo RES; ?>lib/chosen/chosen.css" />
<?php $this->load->view('shared/upload-file-css'); ?>
<?php $this->load->view('shared/alert'); ?>
<div class="row">
    <div class="col-sm-10 col-md-10">       
        <div>
            <h3>电话兑换</h3>
            <br/>
            <h4>
                <strong>&nbsp卡号:</strong>
                <strong id="num_code"><?php echo $num_code; ?></strong>
                <strong>&nbsp礼册名称:</strong>
                <strong><?php echo $book_name; ?></strong>
                <strong>&nbsp礼册id:</strong>
                <strong><?php echo $book_id; ?></strong>
                <strong>&nbsp价格:</strong>
                <strong><?php echo $sale_price; ?></strong>
                <strong>&nbsp失效日期:</strong>
                <strong><?php echo $expire_date; ?></strong>
            </h4>

        </div>
        <br/>
        <div>
            <h3>商品列表:</h3>
            <table class="table table-striped table-bordered dTableR" id="gift_tb">
                <thead>
                    <tr>
                        <th class="table_checkbox center">
                            <input name="select_rows" class="select_rows" data-tableid="gift_tb" type="checkbox">
                        </th>
                        <th class="center">商品id</th>
                        <th class="center">商品名称</th>
                        <th class="center">商品价格</th>
                        <th class="center">库存</th>
                        <th class="center">销量</th>
                    </tr>
                </thead>
                <tbody class="center">

                </tbody>        
            </table>
        </div>
        <div class="row">
            <br/>
            <div class="col-sm-10 col-md-10">
                <h3 class="heading">物流信息</h3>
                <form class="form-horizontal" id="fileupload">
                    <fieldset>
                        <div class="form-group">
                            <label for="a_customer_name" class="control-label col-sm-2">收件人</label>
                            <div class="col-sm-4">
                                <input name="a_customer_name" id="a_customer_name" class="input-xlarge form-control" value="" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="a_phone" class="control-label col-sm-2">手机号</label>
                            <div class="col-sm-4">
                                <input name="a_phone" id="a_phone" class="input-xlarge form-control" value="" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="a_postcode" class="control-label col-sm-2">邮编</label>
                            <div class="col-sm-4">
                                <input name="a_postcode" id="a_postcode" class="input-xlarge form-control" value="" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="a_deliver_id" class="control-label col-sm-2">快递</label>
                            <div class="col-sm-4">
                                <select name="a_deliver_id" id="a_deliver_id" data-placeholder="选择快递..." class="chzn_a form-control">
                                    <option value="1" selected="selected">申通</option>
                                    <option value="2">圆通</option>
                                    <option value="3">中通</option>
                                    <option value="4">顺风</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="a_deliver_date" class="control-label col-sm-2">发货时间</label>       
                            <div class="col-sm-4">
                                <input name="a_deliver_date" id="a_deliver_date" class="datepicker" data-date-format="yy-mm-dd">                     
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="a_address" class="control-label col-sm-2">收货地址</label>
                            <div class="col-sm-10">
                                <input name="a_address" id="a_address" class="input-xlarge form-control" value="" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="a_remark" class="control-label col-sm-2">备注</label>
                            <div class="col-sm-10">
                                <textarea name="a_remark" id="a_remark" cols="10" rows="3" class="form-control"></textarea>
                            </div>
                        </div>
                        <br/>
                        <div class="form-group" style="text-align: center;">
                            <div class="col-sm-5"  style="margin-left: 50%;">
                                <div class="btn btn-success col-sm-4" id="add-porder-ok">完成</div>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>

    </div>
</div>

<!-- multiselect -->
<script src="<?php echo RES; ?>lib/multi-select/js/jquery.multi-select.js"></script>
<script src="<?php echo RES; ?>lib/multi-select/js/jquery.quicksearch.js"></script>
<!-- enhanced select (chosen) -->
<script src="<?php echo RES; ?>lib/chosen/chosen.jquery.min.js"></script>
<!-- autosize textareas -->
<script src="<?php echo RES; ?>js/forms/jquery.autosize.min.js"></script>
<!-- user profile functions -->
<script src="<?php echo RES; ?>js/pages/gebo_user_profile.js"></script>

<?php $this->load->view('shared/upload-file'); ?>

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

<script src="<?php echo RES; ?>order/gift_list.js"></script>







