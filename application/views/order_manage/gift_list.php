<!-- datatables -->
<link rel="stylesheet" href="<?php echo RES; ?>lib/datatables/extras/TableTools/media/css/TableTools.css">
<link rel="stylesheet" href="<?php echo RES; ?>/common/common.css" />
<?php $this->load->view('shared/alert'); ?>

<div class="row">
    <div class="col-sm-12 col-md-12">
        <h3 class="heading">电话兑换</h3>
        <div class="empty"></div>
        <div class="w-box-header">
            <span class="control-label col-sm-2">
                卡号：<?php echo $giftcard['num_code']; ?>
            </span>
            <span class="control-label col-sm-3">
                礼册名称：<?php echo $giftcard['book_name']; ?>
            </span>
            <span class="control-label col-sm-2">
                礼册id：<?php echo $giftcard['book_id']; ?>
            </span>
            <span class="control-label col-sm-2">
                价格：<?php echo $giftcard['sale_price']; ?>
            </span>
            <span class="control-label col-sm-3">
                失效日期：<?php echo $giftcard['expire_date']; ?>
            </span>
        </div>
        <div style="margin-top: 10px;margin-bottom: 10px;"><h4>选择商品</h4></div>
        <div id="small_grid" class="wmk_grid">
            <ul>
                <?php foreach ($gift as $v): ?>
                    <li class="thumbnail act_tools checkbox" style="display: list-item;width: 360px;max-height: 100px;float: left;margin-top: 10px; margin-right: 60px;">
                        <label style="width: 350px;max-height: 96px;padding-left: 0px;">
                            <span style="float: right;">
                                <a style="float: right;"><input name='row_sel' type='checkbox' value="<?php echo $v['id']; ?>"></a>
                                <p>商品名称-<?php echo $v['name']; ?></p>
                                <p>商品价格：<?php echo $v['sale_price']; ?>&nbsp;&nbsp;&nbsp;商品id：<?php echo $v['id']; ?></p>
                                <p>库存：<?php echo $v['store_num']; ?>&nbsp;&nbsp;&nbsp;销量：<?php echo $v['sold_num']; ?></p>
                            </span>
                            <span style="max-width: 120px;max-height: 80px;">
                                <?php if(isset($v['pic_ids'][0])):?>
                                <img src="<?php echo RES . $v['pic_ids'][0]['path'] . $v['pic_ids'][0]['name']; ?>" alt="" style="max-width: 120px;max-height: 80px;margin-left: 6px;">
                                <?php endif;?>
                            </span>
                        </label>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div style="clear: both;"></div>
        <div style="margin-top: 30px;margin-bottom: 10px;"><h4>物流信息</h4></div>
        <div class="form-horizontal">
            <fieldset>
                <div class="form-group">
                    <label for="r_user" class="control-label col-sm-2">收件人</label>
                    <div class="col-sm-3">
                        <input name="r_cardid" value="<?php echo $giftcard['card_id']; ?>" type="hidden">
                        <input name="r_codenum" value="<?php echo $giftcard['num_code']; ?>" type="hidden">
                        <input name="r_user" id="r_user" class="input-xlarge form-control" value="" type="text">
                    </div>
                </div>
                <div class="form-group goods-single-own">
                    <label for="r_phone" class="control-label col-sm-2">手机号</label>
                    <div class="col-sm-3">
                        <input name="r_phone" id="r_phone" class="input-xlarge form-control" value="" type="text">
                    </div>
                </div>
                <div class="form-group goods-multiple-own">
                    <label for="r_address" class="control-label col-sm-2">收货地址</label>
                    <div class="col-sm-3">
                        <input name="r_address" id="r_address" class="input-xlarge form-control" value="" type="text">
                    </div>
                </div>
                <div class="form-group goods-multiple-own">
                    <label for="r_postcode" class="control-label col-sm-2">邮政编码</label>
                    <div class="col-sm-3">
                        <input name="r_postcode" id="r_postcode" class="input-xlarge form-control" value="" type="text">
                    </div>
                </div>
                <div class="form-group goods-multiple-own">
                    <label for="r_date" class="control-label col-sm-2">发货时间</label>
                    <div class="col-sm-3">
                        <input name="r_date" id="r_date" class="input-xlarge form-control" value="" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="r_deliver" class="control-label col-sm-2">默认快递</label>
                    <div class="col-sm-2">
                        <?php $n = 0;?>
                        <select name="r_deliver" id="r_deliver" data-placeholder="选择商品快递..." class="chzn_a form-control">
                            <?php foreach($deliver as $d):?>
                            <?php $n++;?>
                            <option value="<?php echo $d['id']?>" <?php echo $n==1?"selected='selected'":'';?>><?php echo $d['name']?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="remark" class="control-label col-sm-2">备注</label>
                    <div class="col-sm-4">
                        <textarea name="remark" id="remark" cols="6" rows="2" class="form-control"></textarea>
                    </div>
                </div>
                <br/>
                <div class="form-group" style="text-align: center;">
                    <div class="col-sm-8"  style="margin-left: 20%;">
                        <div class="btn btn-success col-sm-4" id="selected-goods-ok">完成</div>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
</div>

<script src="<?php echo RES; ?>order/gift_list.js"></script>
