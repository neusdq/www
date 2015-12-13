<!-- multiselect -->
<link rel="stylesheet" href="<?php echo RES; ?>lib/multi-select/css/multi-select.css" />
<!-- enhanced select -->
<link rel="stylesheet" href="<?php echo RES; ?>lib/chosen/chosen.css" />

<?php $this->load->view('shared/upload-file-css'); ?>
<?php $this->load->view('shared/alert'); ?>

<div class="row">
    <div class="col-sm-12 col-md-12">
        <h3 class="heading">编辑微信模版</h3>
        <form class="form-horizontal" id="fileupload">
            <fieldset>
                <input name="g_id" id="g_id" type="hidden" value="<?php echo $wechat['id'] ?>">
                <div class="form-group">
                    <label for="g_name" class="control-label col-sm-2">模版名称</label>
                    <div class="col-sm-2">
                        
                        <input name="g_name" id="g_name" class="input-xlarge form-control" value="<?php echo $wechat['name']; ?>" type="text">
                    </div>
                    <label for="g_style" class="control-label col-sm-1">样式</label>
                    <div class="col-sm-2">
                        <select name="g_style" id="g_style" data-placeholder="选择样式..." class="chzn_a form-control">
                            <option value="1" <?php echo $wechat['style'] == 1 ? 'selected="selected"' : ''; ?>>样式1</option>
                            <option value="2" <?php echo $wechat['style'] == 2 ? 'selected="selected"' : ''; ?>>样式2</option>
                            <option value="3" <?php echo $wechat['style'] == 3 ? 'selected="selected"' : ''; ?>>样式3</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="g_vedio_id" class="control-label col-sm-2">视频id</label>
                    <div class="col-sm-2">
                        
                        <input name="g_vedio_id" id="g_vedio_id" class="input-xlarge form-control" value="<?php echo $wechat['vedio_id']; ?>" type="text">
                    </div>
                    <label for="g_pic_id" class="control-label col-sm-1">图片id</label>
                    <div class="col-sm-2">

                        <input name="g_pic_id" id="g_pic_id" class="input-xlarge form-control" value="<?php echo $wechat['pic_id']; ?>" type="text">
                    </div>
                    <label for="g_audio_id" class="control-label col-sm-1">音频id</label>
                    <div class="col-sm-2">

                        <input name="g_audio_id" id="g_audio_id" class="input-xlarge form-control" value="<?php echo $wechat['audio_id']; ?>" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="g_sender" class="control-label col-sm-2">送礼人</label>
                    <div class="col-sm-2">
                        <input name="g_sender" id="g_sender" class="input-xlarge form-control" value="<?php echo $wechat['sender']; ?>" type="text">
                    </div>
                    <label for="g_reciver" class="control-label col-sm-1">收礼人</label>
                    <div class="col-sm-2">
                        <input name="g_reciver" id="g_reciver" class="input-xlarge form-control" value="<?php echo $wechat['reciver']; ?>" type="text">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="g_copywriter" class="control-label col-sm-2">祝福语</label>
                    <div class="col-sm-5">
                        <textarea name="g_copywriter" id="g_copywriter" cols="10" rows="3" class="form-control"><?php echo $wechat['copywriter']; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="g_remark" class="control-label col-sm-2">备注</label>
                    <div class="col-sm-5">
                        <textarea name="g_remark" id="g_remark" cols="10" rows="3" class="form-control"><?php echo $wechat['remark']; ?></textarea>
                    </div>
                </div>
                <br/>
                <div class="form-group" style="text-align: center;">
                    <div class="col-sm-8"  style="margin-left: 30%;">
                        <div class="btn btn-success col-sm-4" id="update-wechat-ok">完成</div>
                    </div>
                </div>
            </fieldset>
        </form>
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

<script>
    $(document).ready(function () {
        $(".chzn_a").chosen({
            allow_single_deselect: true
        });
        //成功提示框设置
        $('#alert-success').modal({
            backdrop: false,
            show: false
        });
    

        $("#update-wechat-ok").on('click', function () {
            var flag = true;
            var g_id = $("#g_id").val();
            var g_name = $("#g_name").val();
            var g_style = $("#g_style").val();
            var g_vedio_id = $("#g_vedio_id").val();
            var g_audio_id = $("#g_audio_id").val();
            var g_pic_id = $("#g_pic_id").val();
            var g_sender = $("#g_sender").val();
            var g_reciver = $("#g_reciver").val();
            var g_copywriter = $("#g_copywriter").val();
            var g_remark = $("#g_remark").val();
           
            if (g_name == '' || g_name == undefined) {
                flag = flag & false;
                alertError("#alert-error", '名称不能为空！');
                return;
            }
            if (g_sender == '' || g_sender == undefined) {
                flag = flag & false;
                alertError("#alert-error", '送礼人不能为空！');
                return;
            }
            if (g_reciver == '' || g_reciver == undefined) {
                flag = flag & false;
                alertError("#alert-error", '收礼人不能为空！');
                return;
            }
            if (flag) {
                $.post('/wechat_manage/update_wechat_info',
                        {
                            id:g_id,name: g_name, style: g_style, 
                            vedio_id: g_vedio_id, audio_id: g_audio_id,pic_id:g_pic_id,
                            sender: g_sender, reciver: g_reciver,remark:g_remark,copywriter:g_copywriter
                        }, function (ret) {
                    var d = $.parseJSON(ret);
                    if (d.errCode == 0) {
                        alertSuccess("#alert-success", '/wechat_manage/wechat_list');
                    } else {
                        alertError("#alert-error", d.msg);
                    }
                });
            }

        });
    });
</script>
