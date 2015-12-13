<!-- multiselect -->
<link rel="stylesheet" href="<?php echo RES; ?>lib/multi-select/css/multi-select.css" />
<!-- enhanced select -->
<link rel="stylesheet" href="<?php echo RES; ?>lib/chosen/chosen.css" />
<link rel="stylesheet" href="<?php echo RES; ?>lib/datepicker/bootstrap-datepicker.min.css" />
<?php $this->load->view('shared/upload-file-css'); ?>
<?php $this->load->view('shared/alert'); ?>
<div class="row">
    <div class="col-sm-12 col-md-12">
        <h3 class="heading">新建微信模版</h3>
        <form class="form-horizontal" id="fileupload">
            <fieldset>
                <div class="form-group">
                    <label for="a_name" class="control-label col-sm-2">模版名称</label>
                    <div class="col-sm-2">
                        <input name="a_name" id="a_name" class="input-xlarge form-control" value="" type="text">
                    </div>
                    <label for="a_style" class="control-label col-sm-1">样式</label>
                    <div class="col-sm-2">
                        <select name="a_style" id="a_style" data-placeholder="选择样式..." class="chzn_a form-control">
                            <option value="1" selected="selected">样式1</option>
                            <option value="2">样式2</option>
                            <option value="3">样式3</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="a_vedio_id" class="control-label col-sm-2">视频id</label>
                    <div class="col-sm-2">
                        <input name="a_vedio_id" id="a_vedio_id" class="input-xlarge form-control" value="" type="text">
                    </div>
                    <label for="a_pic_id" class="control-label col-sm-1">图片id</label>
                    <div class="col-sm-2">
                        <input name="a_pic_id" id="a_pic_id" class="input-xlarge form-control" value="" type="text">
                    </div>
                    <label for="a_audio_id" class="control-label col-sm-1">音频id</label>
                    <div class="col-sm-2">
                        <input name="a_audio_id" id="a_audio_id" class="input-xlarge form-control" value="" type="text">
                    </div>
                  
                </div>
                <div class="form-group">
                    <label for="a_sender" class="control-label col-sm-2">送礼人</label>
                    <div class="col-sm-2">
                        <input name="a_sender" id="a_sender" class="input-xlarge form-control" value="" type="text">
                    </div>
                    <label for="a_reciver" class="control-label col-sm-2">收礼人</label>
                    <div class="col-sm-2">
                        <input name="a_reciver" id="a_reciver" class="input-xlarge form-control" value="" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="a_copywriter" class="control-label col-sm-2">祝福语</label>
                    <div class="col-sm-5">
                        <textarea name="a_copywriter" id="a_copywriter" cols="10" rows="3" class="form-control"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="a_remark" class="control-label col-sm-2">备注</label>
                    <div class="col-sm-5">
                        <textarea name="a_remark" id="a_remark" cols="10" rows="3" class="form-control"></textarea>
                    </div>
                </div>
                <br/>
                <div class="form-group" style="text-align: center;">
                    <div class="col-sm-5"  style="margin-left: 30%;">
                        <div class="btn btn-success col-sm-4" id="add-wechat-ok">完成</div>
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
            show:false
        });
        
        $("#add-wechat-ok").die().live('click',function(){
            var flag = true;
            var name = $("#a_name").val();
            var style = $('#a_style').val();     
            var vedio_id = $("#a_vedio_id").val(); //联系人
            var pic_id = $("#a_pic_id").val();    
            var audio_id = $("#a_audio_id").val();   //邮编
            var sender = $("#a_sender").val();
            var reciver = $("#a_reciver").val();
            var copywriter = $("#a_copywriter").val();
            
            var remark = $("#a_remark").val();
            if(name=='' || name==undefined){
                flag = flag & false;
                alertError("#alert-error",'模版名称不能为空！');
                return ;
            }
            if(flag){
                $.post('/wechat_manage/add_wechat',
                {
                    name:name,style:style,
                    vedio_id:vedio_id,pic_id:pic_id,audio_id:audio_id,
                    sender:sender,reciver:reciver,copywriter:copywriter,
                    remark:remark
                },function(ret){
                    var d = $.parseJSON(ret);
                    if(d.errCode==0){
                        alertSuccess("#alert-success",'/business_manage/wechat_list');
                    }else{
                        alertError("#alert-error",d.msg);
                    }
                });
            }
            
        });
    });
</script>
