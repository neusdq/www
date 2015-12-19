<!-- multiselect -->
<link rel="stylesheet" href="<?php echo RES; ?>lib/multi-select/css/multi-select.css" />
<!-- enhanced select -->
<link rel="stylesheet" href="<?php echo RES; ?>lib/chosen/chosen.css" />
<?php $this->load->view('shared/upload-file-css'); ?>
<?php $this->load->view('shared/alert'); ?>
<div class="row">
    <div class="col-sm-10 col-md-10">
        <h3 class="heading">电话兑换</h3>
        <div class="form-horizontal">
            <fieldset>
                <div class="form-group">
                    <label for="a_numcode" class="control-label col-sm-2">卡号</label>
                    <div class="col-sm-4">
                        <input name="a_numcode" id="a_numcode" class="form-control" value="" type="text">
                    </div>
                    <label class="col-lg-2 control-label alert-label-error" id="a-numcode-error" style="text-align: left;color: red;">

                    </label>
                </div>
                <br/><br/>
                
                <div class="form-group">
                    <label for="a_password" class="control-label col-sm-2">密码</label>
                    <div class="col-sm-4">
                        <input name="a_password" id="a_password" class="form-control" value="" type="text">
                    </div>
                    <label class="col-lg-2 control-label alert-label-error" id="a-password-error" style="text-align: left;color: red;">

                    </label>
                </div>
                <br/>
                <div class="form-group" style="text-align: center;">
                    <div  style="margin-left: 25%">
                        <div class="btn btn-success col-sm-2" id="add-porder-ok">提交</div>
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



<script>
    $(document).ready(function () {
        
        //成功提示框设置
        $('#alert-success').modal({
            backdrop: false,
            show:false
        });
        
        $("span.delete").die().live('click',function(){
            $(this).parent().remove();
        })
        
        $("#add-porder-ok").die().live('click',function(){
            var flag = true;
            var numcode = $("#a_numcode").val();
            var password = $('#a_password').val();
            $(".alert-label-error").text('');
            if(numcode=='' || numcode==undefined){
                $("#a-numcode-error").text('请输入卡号！');
                flag = flag & false;
            }
            if(password=='' || password==undefined){
                $("#a-password-error").text('请输入卡号密码！');
                flag = flag & false;
            }
            if(flag){
                $.post('/order_manage/check_cardauth',
                {
                    numcode:numcode,password:password
                },function(ret){
                    var d = $.parseJSON(ret);
                    if(d.errCode==0){
                        alertSuccess("#alert-success",'/order_manage/gift_list?id='+d.val);
                    }else{
                        alertError("#alert-error",d.msg);
                    }
                });
            }
            
        });
    });
</script>
