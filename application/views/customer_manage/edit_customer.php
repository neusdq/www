<!-- multiselect -->
<link rel="stylesheet" href="<?php echo RES; ?>lib/multi-select/css/multi-select.css" />
<!-- enhanced select -->
<link rel="stylesheet" href="<?php echo RES; ?>lib/chosen/chosen.css" />

<?php $this->load->view('shared/upload-file-css'); ?>
<?php $this->load->view('shared/alert'); ?>

<div class="row">
    <div class="col-sm-12 col-md-12">
        <h3 class="heading">编辑客户</h3>
        <form class="form-horizontal" id="fileupload">
            <fieldset>
                <input name="g_id" id="g_id" type="hidden" value="<?php echo $customer['id'] ?>">
                <div class="form-group">
                    <label for="g_name" class="control-label col-sm-2">客户名称</label>
                    <div class="col-sm-2">
                        
                        <input name="g_name" id="g_name" class="input-xlarge form-control" value="<?php echo $customer['name']; ?>" type="text">
                    </div>
                    <label for="g_type" class="control-label col-sm-1">客户类型</label>
                    <div class="col-sm-2">
                        <select name="g_type" id="g_type" data-placeholder="选择类型..." class="chzn_a form-control">
                            <option value="1" <?php echo $customer['type'] == 1 ? 'selected="selected"' : ''; ?>>代理商</option>
                            <option value="2" <?php echo $customer['type'] == 2 ? 'selected="selected"' : ''; ?>>企业大客户</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="g_contact_person" class="control-label col-sm-2">联系人</label>
                    <div class="col-sm-2">
                        
                        <input name="g_contact_person" id="g_contact_person" class="input-xlarge form-control" value="<?php echo $customer['contact_person']; ?>" type="text">
                    </div>
                    <label for="g_phone" class="control-label col-sm-1">联系电话</label>
                    <div class="col-sm-2">

                        <input name="g_phone" id="g_phone" class="input-xlarge form-control" value="<?php echo $customer['phone']; ?>" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="g_postcode" class="control-label col-sm-2">邮编</label>
                    <div class="col-sm-2">
                        
                        <input name="g_postcode" id="g_postcode" class="input-xlarge form-control" value="<?php echo $customer['postcode']; ?>" type="text">
                    </div>
                    <label for="g_email" class="control-label col-sm-1">邮箱</label>
                    <div class="col-sm-2">

                        <input name="g_email" id="g_email" class="input-xlarge form-control" value="<?php echo $customer['email']; ?>" type="text">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="g_address" class="control-label col-sm-2">地址</label>
                    <div class="col-sm-4">
                        <input name="g_address" id="g_address" class="input-xlarge form-control" value="<?php echo $customer['address']; ?>" type="text">
                    </div>
                </div>
     
                <div class="form-group">
                    <label for="g_remark" class="control-label col-sm-2">备注</label>
                    <div class="col-sm-4">
                        <textarea name="g_remark" id="g_remark" cols="10" rows="3" class="form-control"><?php echo $customer['remark'] ?></textarea>
                    </div>
                </div>
                <br/>
                <div class="form-group" style="text-align: center;">
                    <div class="col-sm-8"  style="margin-left: 30%;">
                        <div class="btn btn-success col-sm-4" id="update-customer-ok">完成</div>
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
    

        $("#update-customer-ok").on('click', function () {
            var flag = true;
            var g_id = $("#g_id").val();
            var g_name = $("#g_name").val();
            var g_type = $("#g_type").val();
            var g_contact_person = $("#g_contact_person").val();
            var g_phone = $("#g_phone").val();
            var g_postcode = $("#g_postcode").val();
            var g_email = $("#g_email").val();
            var g_address = $("#g_address").val();
            var g_remark = $("#g_remark").val();
           
            if (g_name == '' || g_name == undefined) {
                flag = flag & false;
                alertError("#alert-error", '客户名称不能为空！');
                return;
            }
            if (g_contact_person == '' || g_contact_person == undefined) {
                flag = flag & false;
                alertError("#alert-error", '联系人不能为空！');
                return;
            }
            if (g_phone == '' || g_phone == undefined) {
                flag = flag & false;
                alertError("#alert-error", '联系电话不能为空！');
                return;
            }
            if (g_postcode == '' || g_postcode == undefined) {
                flag = flag & false;
                alertError("#alert-error", '邮编不能为空！');
                return;
            }
            if (g_email == '' || g_email == undefined) {
                flag = flag & false;
                alertError("#alert-error", '邮箱不能为空！');
                return;
            }
            if (g_address == '' || g_address == undefined) {
                flag = flag & false;
                alertError("#alert-error", '地址不能为空！');
                return;
            }
            if (flag) {
                $.post('/customer_manage/update_customer_info',
                        {
                            id:g_id,name: g_name, contact_person: g_contact_person, 
                            phone: g_phone, postcode: g_postcode,type:g_type,
                            email: g_email, address: g_address,remark:g_remark
                        }, function (ret) {
                    var d = $.parseJSON(ret);
                    if (d.errCode == 0) {
                        alertSuccess("#alert-success", '/customer_manage/customer_list');
                    } else {
                        alertError("#alert-error", d.msg);
                    }
                });
            }

        });
    });
</script>
