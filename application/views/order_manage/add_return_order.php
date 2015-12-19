<!-- multiselect -->
<link rel="stylesheet" href="<?php echo RES; ?>lib/multi-select/css/multi-select.css" />
<!-- enhanced select -->
<link rel="stylesheet" href="<?php echo RES; ?>lib/chosen/chosen.css" />
<?php $this->load->view('shared/upload-file-css'); ?>
<?php $this->load->view('shared/alert'); ?>
<style type="text/css">
    .add_gift_list_tb{
        margin-left: 35px;
    }
    .add_gift_list_tb button{
        margin: 10px 0;
    }
    .add_gift_list_tb table th,.add_gift_list_tb table td{
        text-align: center;
    }
    .add_card{
        padding-left: 20px;
        padding-right: 20px;
    }
    .gift_price{
        width:100px
    }
    .modal-body center{
        text-align: right;
    }
    .del_gift_list{
        cursor: pointer;
    }
    #giftBook,#giftBook_chzn,giftBook_chzn,div.chzn-drop{ min-width: 160px;}
    .chzn-search>input{min-width: 150px;}
</style>

<div class="row">
    <div class="col-sm-12 col-md-12">
        <h3 class="heading">退货</h3>
        <div class="form-horizontal" id="fileupload">
            <fieldset>

                <div class="form-group">
                    <label for="order_id" class="control-label col-sm-1">订单:</label>
                    <div class="col-sm-2">
                        <input name="order_id" id="order_id" class="input-xlarge form-control" value="" type="text">
                    </div> 
                    <div class="pull-left sort-disabled margin-left-2">
                        <button class="btn btn-success label margin-left-2" id="search_order">查询</button>
                    </div>
                </div> 

                <div class="form-group">

                    <label for="card_num" class="control-label col-sm-1">卡号:</label>
                    <div class=" col-sm-2">
                        <input class="form-control" id="card_num" type="text" value="" readonly>
                    </div>

                    <label for="price" class="control-label col-sm-1">面值:</label>
                    <div class=" col-sm-2">
                        <input class="form-control" id="price" type="text" value="" readonly>
                    </div>

                </div>

                <div class="form-group">

                    <label for="gift_book" class="control-label col-sm-1">礼册:</label>
                    <div class=" col-sm-2">
                        <input class="form-control" id="gift_book" type="text" value="" readonly>
                    </div>

                    <label for="gift" class="control-label col-sm-1">商品:</label>
                    <div class=" col-sm-2">
                        <input class="form-control" id="gift" type="text" value="" readonly>
                    </div>

                </div>
                <div class="form-group">

                    <label for="customer" class="control-label col-sm-1">客户:</label>
                    <div class=" col-sm-2">
                        <input class="form-control" id="customer" type="text" value="" readonly>
                    </div>

                    <label for="phone" class="control-label col-sm-1">手机:</label>
                    <div class=" col-sm-2">
                        <input class="form-control" id="phone" type="text" value="" readonly>
                    </div>
                    <label for="deal_date" class="control-label col-sm-1">兑换日期:</label>
                    <div class=" col-sm-3">
                        <input class="form-control" id="deal_date" type="text" value="" readonly>
                    </div>

                </div>
                <div class="form-group">

                    <label for="address" class="control-label col-sm-1">地址:</label>
                    <div class=" col-sm-4">
                        <input class="form-control" id="address" type="text" value="" readonly>
                    </div>


                </div>

                <div class="form-group">
                    <label for="return_amount" class="control-label col-sm-1">退款金额:</label>
                    <div class="col-sm-2">
                        <input name="return_amount" id="return_amount" class="input-xlarge form-control" value="" type="text">
                    </div>
                    <label for="bank" class="control-label col-sm-1">银行:</label>
                    <div class="col-sm-2">
                        <select name="bank" id="bank" data-placeholder="银行" class="chzn_a form-control">
                            <option value="1" selected="selected">中国银行</option>
                            <option value="2">招商银行</option>
                            <option value="3">农业银行</option>
                            <option value="4">工商银行</option>
                            <option value="5">建设银行</option>
                            <option value="6">广发银行</option>
                            <option value="7">交通银行</option>
                            <option value="8">北京银行</option>
                            <option value="9">民生银行</option>
                            <option value="10">光大银行</option>
                            <option value="11">兴业银行</option>
                            <option value="12">支付宝</option>
                            <option value="13">其它</option>
                        </select>
                    </div>


                </div>

                <div class="form-group">

                    <label for="open_bank_address" class="control-label col-sm-1">开户行:</label>
                    <div class=" col-sm-4">
                        <input class="form-control" id="open_bank_address" type="text" value="">
                    </div>

                </div>
                <div class="form-group">

                    <label for="bank_card_num" class="control-label col-sm-1">账号:</label>
                    <div class=" col-sm-2">
                        <input class="form-control" id="bank_card_num" type="text" value="">
                    </div>
                    <label for="bank_card_name" class="control-label col-sm-1">开户名:</label>
                    <div class=" col-sm-2">
                        <input class="form-control" id="bank_card_name" type="text" value="">
                    </div>

                </div>

                <div class="form-group">
                    <label for="remark" class="control-label col-sm-1">备注:</label>
                    <div class="col-sm-5">
                        <textarea name="remark" id="remark" cols="10" rows="3" class="form-control"></textarea>
                    </div>
                </div>

                <br/>
                <div class="form-group" style="text-align: center;">
                    <div class="col-sm-5"  style="margin-left: 30%;">
                        <div class="btn btn-success col-sm-4" id="add-rorder-ok">完成</div>
                    </div>
                </div>
            </fieldset>
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
<script src="<?php echo RES; ?>order/add_return_order.js"></script>
