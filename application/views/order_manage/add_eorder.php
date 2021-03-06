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
        <h3 class="heading">新建实物销售单</h3>
        <div class="form-horizontal" id="fileupload">
            <fieldset>

                <div class="form-group">

                    <label for="a_sales" class="control-label col-sm-2">销售员</label>
                    <div class="col-sm-2">
                        <select name="a_sales" id="a_sales" data-placeholder="选择销售员" class="chzn_a form-control">
                            <?php $i = 0; ?>
                            <?php foreach ($sales as $v): ?>
                                <option value="<?php echo $v['id']; ?>" <?php echo $i == 0 ? 'selected="selected"' : ''; ?>>
                                    <?php echo $v['nick_name'] ? $v['nick_name'] : $v['user_name']; ?>
                                </option>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <label for="a_deal_date" class="control-label col-sm-1">交易日期</label>
                    <div class=" col-sm-2">
                        <input class="form-control" readonly id="a_deal_date" type="text" value="<?php echo date('Y-m-d');?>">
                    </div>

                </div>

                <div class="form-group">
                    <label for="a_customer" class="control-label col-sm-2">客户名称</label>
                    <div class="col-sm-2">
                        <select name="a_customer" id="a_customer" data-placeholder="选择客户" class="chzn_a form-control">
                            <option value="">请选择</option>
                            <?php foreach ($customer as $v): ?>
                                <option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <label for="a_enduser" class="control-label col-sm-1">最终用户</label>
                    <div class="col-sm-2">
                        <input name="a_enduser" id="a_enduser" class="input-xlarge form-control" value="" type="text">
                    </div>
                </div>

                <div class="form-group">
                    <label for="a_contact_person" class="control-label col-sm-2">联系人</label>
                    <div class="col-sm-2">
                        <input name="a_contact_person" id="a_contact_person" class="input-xlarge form-control" value="" type="text">
                    </div>

                    <label for="a_telephone" class="control-label col-sm-1">电话</label>
                    <div class="col-sm-2">
                        <input name="a_telephone" id="a_telephone" class="input-xlarge form-control" value="" type="text">
                    </div>

                </div>

                <div class="form-group">
                    <label for="a_address" class="control-label col-sm-2">地址</label>
                    <div class="col-sm-5">
                        <input name="a_address" id="a_address" class="input-xlarge form-control" value="" type="text">
                    </div>
                </div>

   



                <div class="form-group">
                    <label for="a_remark" class="control-label col-sm-2">备注</label>
                    <div class="col-sm-5">
                        <textarea name="a_remark" id="a_remark" cols="10" rows="3" class="form-control"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-1"></label>
                    <div class="add_gift_list_tb col-sm-6">
                        <button class="btn btn-info add_card">增加</button>
                        <table class="table table-striped table-bordered " id="add_gift_list_tb">
                            <thead>
                                <tr>
                                  <th class="center">商品名称</th>
                                    <th class="center">单价</th>
                                    <th class="center">折扣</th>
                                    <th class="center">数量</th>
                                    <th class="center">总价</th>
                                    <th class="center">备注</th>
                                    <th class="center">操作</th>
                                </tr>
                            </thead>
                            <tbody class="center">

                            </tbody>        
                        </table>
                    </div>

                </div>   
                <br/>
                <div class="form-group" style="text-align: center;">
                    <div class="col-sm-5"  style="margin-left: 30%;">
                        <div class="btn btn-success col-sm-4" id="giftcard-order-ok">完成</div>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>



    <!---------新建弹层---------->
    <div class="modal fade" id="add-card-modal">
        <div class="modal-dialog">
            <div class="modal-content" id="modal-max-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title">增加礼册</h3>
                </div>
                <div class="modal-body">
                    <table class="table table-condensed table-striped">
                        <tbody>
                            <tr>
                                <td class="center">选择商品</td>
                                <td>
                                    <select name="giftBook" id="giftBook" data-placeholder="选择商品" class="chzn_a form-control">
                                        <option value="">请选择</option>
                                        <?php $i = 0; ?>
        
                                        <?php foreach ($gift as $v): ?>
                                            <option value="<?php echo $v['id']; ?>">
                                                <?php echo $v['name']; ?>
                                            </option>
                                            <?php $i++; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td class="alert-label-error center"></td>
                            </tr>
                            <tr>
                                <td class="center">单价</td>
                                <td>
                                    <input name="price" id="price" class="input-xlarge form-control" value="" type="text">
                                </td>
                                <td class="alert-label-error center" ></td>
                            </tr>

                            <tr>
                                <td class="center">折扣</td>
                                <td>
                                    <input name="discount" id="discount" class="input-xlarge form-control" value="" type="text">
                                </td>
                                <td class="alert-label-error center"></td>
                            </tr>

                            <tr>
                                <td class="center">数量</td>
                                <td>
                                    <input name="book_count" id="book_count" class="input-xlarge form-control" value="" type="text">
                                </td>
                                <td class="alert-label-error center"></td>
                            </tr>

                            <tr>
                                <td class="center">总价</td>
                                <td>
                                    <input name="sum_price" id="sum_price" class="input-xlarge form-control" value="" type="text" placeholder="点击自动计算总价">
                                </td>
                                <td class="alert-label-error center"></td>
                            </tr>
                            
                            <tr>
                                <td class="center">备注</td>
                                <td>
                                    <textarea name="book_remark" id="book_remark" cols="10" rows="3" class="form-control"></textarea>
                                </td>
                                <td class="alert-label-error center"></td>
                            </tr>

                            <tr>
                                <td colspan="3" class="center">
                                    <button type="button" class="btn btn-success" id="giftcard-order-btn">确认</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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
<script src="<?php echo RES; ?>order/add_eorder.js"></script>

<script>
    var giftArr = [];
    var customerArr = <?php echo json_encode($customer); ?>;
    var gifts = <?php echo json_encode($gift); ?>;
</script>
