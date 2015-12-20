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
        <h3 class="heading">换货</h3>
        <div class="form-horizontal" id="fileupload">
            <fieldset>

                <div class="form-group">
                    <label for="order_id" class="control-label col-sm-1">订单:</label>
                    <div class="col-sm-2">
                        <input name="order_id" id="order_id" class="input-xlarge form-control" value="<?php echo $order_id ?>" type="text" readonly>
                    </div>
                </div> 

                <div class="form-group">

                    <label for="card_num" class="control-label col-sm-1">卡号:</label>
                    <div class=" col-sm-2">
                        <input class="form-control" id="card_num" type="text" value="<?php echo $order_info['card_num'] ?>" readonly>
                    </div>

                    <label for="price" class="control-label col-sm-1">面值:</label>
                    <div class=" col-sm-2">
                        <input class="form-control" id="price" type="text" value="<?php echo $order_info['sale_price'] ?>" readonly>
                    </div>

                </div>

                <div class="form-group">

                    <label for="gift_book" class="control-label col-sm-1">礼册:</label>
                    <div class=" col-sm-2">
                        <input class="form-control" id="gift_book" type="text" value="<?php echo $order_info['book_name'] ?>" readonly>
                    </div>

                    <label for="gift" class="control-label col-sm-1">商品:</label>
                    <div class=" col-sm-2">
                        <input class="form-control" id="gift" type="text" value="<?php echo $order_info['gift_name'] ?>" readonly>
                    </div>

                </div>
                <div class="form-group">

                    <label for="customer" class="control-label col-sm-1">客户:</label>
                    <div class=" col-sm-2">
                        <input class="form-control" id="customer" type="text" value="<?php echo $order_info['customer_name'] ?>" readonly>
                    </div>

                    <label for="phone" class="control-label col-sm-1">手机:</label>
                    <div class=" col-sm-2">
                        <input class="form-control" id="phone" type="text" value="<?php echo $order_info['phone'] ?>" readonly>
                    </div>
                    <label for="deal_date" class="control-label col-sm-1">兑换日期:</label>
                    <div class=" col-sm-2">
                        <input class="form-control" id="deal_date" type="text" value="<?php echo $order_info['ctime'] ?>" readonly>
                    </div>

                </div>
                <div class="form-group">

                    <label for="address" class="control-label col-sm-1">地址:</label>
                    <div class=" col-sm-4">
                        <input class="form-control" id="address" type="text" value="<?php echo $order_info['address'] ?>" readonly>
                    </div>


                </div>
                <div class="form-group">
                    <label for="exchange_gift" class="control-label col-sm-1">换取商品:</label>
                    <div class="col-sm-2">
                        <select name="exchange_gift" id="exchange_gift" data-placeholder="换取商品" class="form-control">
                            <?php foreach ($gift_arr as $v): ?>
                                <option value="<?php echo $v['id']; ?>" <?php echo $v['id'] == $exchange_info['to_gift'] ? 'selected="selected"' : ''; ?>>
                                    <?php echo $v['name'];?>
                                </option>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>

                <div class="form-group">

                    <label for="diliver_money" class="control-label col-sm-1">快递费用:</label>
                    <div class=" col-sm-4">
                        <input class="form-control" id="diliver_money" type="text" value="<?php echo $exchange_info['diliver_money'] ?>">
                    </div>

                </div>

                <div class="form-group">
                    <label for="remark" class="control-label col-sm-1">备注:</label>
                    <div class="col-sm-5">
                        <textarea name="remark" id="remark" cols="10" rows="3" class="form-control"><?php echo $exchange_info['remark'] ?></textarea>
                    </div>
                </div>

                <br/>
                <div class="form-group" style="text-align: center;">
                    <div class="col-sm-5"  style="margin-left: 30%;">
                        <div class="btn btn-success col-sm-4" id="add-exorder-ok">完成</div>
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
<script src="<?php echo RES; ?>order/edit_exchange_order.js"></script>
