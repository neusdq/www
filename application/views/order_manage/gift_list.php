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
                <li class="thumbnail act_tools" style="position: absolute; top: 0px; left: 75px; display: list-item;">
                    <a href="<?php echo RES; ?>/gallery/Image01.jpg" title="Image_1 title long title long title long" rel="gallery" class="cboxElement">
                        <img src="<?php echo RES; ?>/gallery/Image01_tn.jpg" alt="">
                    </a>
                    <p>
                        <a href="javascript:void(0)" title="Remove"><i class="glyphicon glyphicon-trash"></i></a>
                        <a href="javascript:void(0)" title="Edit"><i class="glyphicon glyphicon-pencil"></i></a>
                        <span>Image title long title long title long</span>
                    </p>
                </li>
            </ul>
        </div>
    </div>
</div>

