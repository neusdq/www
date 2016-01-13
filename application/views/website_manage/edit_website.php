<!-- multiselect -->
<link rel="stylesheet" href="<?php echo RES; ?>lib/multi-select/css/multi-select.css" />
<!-- enhanced select -->
<link rel="stylesheet" href="<?php echo RES; ?>lib/chosen/chosen.css" />

<?php $this->load->view('shared/upload-file-css'); ?>
<?php $this->load->view('shared/alert'); ?>

<div class="row">
    <div class="col-sm-12 col-md-12">
        <h3 class="heading">编辑网站</h3>
        <form class="form-horizontal" id="fileupload">
            <fieldset>
                <input name="g_id" id="g_id" type="hidden" value="<?php echo $website['id'] ?>">
                <div class="form-group">
                    <label for="g_name" class="control-label col-sm-2">网站名称</label>
                    <div class="col-sm-2">
                        
                        <input name="g_name" id="g_name" class="input-xlarge form-control" value="<?php echo $website['name']; ?>" type="text">
                    </div>
                    <label for="g_type" class="control-label col-sm-1">网站类型</label>
                    <div class="col-sm-2">
                        <select name="g_type" id="g_type" data-placeholder="选择类型..." class="chzn_a form-control">
                            <option value="1" <?php echo $website['type'] == 1 ? 'selected="selected"' : ''; ?>>兑换网站</option>
                            <option value="2" <?php echo $website['type'] == 2 ? 'selected="selected"' : ''; ?>>礼册商场</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="g_domain" class="control-label col-sm-2">绑定域名</label>
                    <div class="col-sm-2">
                        
                        <input name="g_domain" id="g_domain" class="input-xlarge form-control" value="<?php echo $website['domain']; ?>" type="text">
                    </div>
                    <label for="g_hotline" class="control-label col-sm-1">客服热线</label>
                    <div class="col-sm-2">

                        <input name="g_hotline" id="g_hotline" class="input-xlarge form-control" value="<?php echo $website['hotline']; ?>" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="g_qq" class="control-label col-sm-2">客服QQ</label>
                    <div class="col-sm-2">
                        
                        <input name="g_qq" id="g_qq" class="input-xlarge form-control" value="<?php echo $website['qq']; ?>" type="text">
                    </div>
                    <label for="g_expire_date" class="control-label col-sm-2">有效期</label>
                    
                    <div class="col-sm-2">
                        <input name="g_expire_date" id="g_expire_date" class="datepicker" data-date-format="yy-mm-dd" value="<?php echo $website['expire_date']; ?>">                     
                    </div>
                </div>
                <div class="form-group">
                    <label for="fileinput" class="control-label col-sm-2">上传</label>
                    <!-- The table listing the files available for upload/download -->
                    <span role="presentation" class="table table-striped">
                     <ul class="files">
                            <?php foreach ($website['pic_ids'] as $img): ?>
                                <li class="template-download fade none-list-style in">
                                    <p class="preview">
                                        <a href="<?php echo UPLOAD.$img['path'].$img['name']; ?>" class="img-uploaded" title="<?php echo $img['name']; ?>">
                                            <img src="<?php echo UPLOAD.$img['path'].'thumb_'.$img['name']; ?>">
                                        </a>
                                    </p>
                                    <span class="delete text-center btn-danger img-uploaded" id="<?php echo $img['id'];?>">
                                        删除
                                    </span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </span>
                    <span class="btn btn-success fileinput-button" id="fileupload-bnt" title="添加图片">
                        <i class="glyphicon glyphicon-plus"></i>
                        <!-- The file input field used as target for the file upload widget -->
                        <input id="fileupload-img" type="file" name="files" multiple="" data-url="/upload_file/img_upload?" onclick="return checkUpload(5);">
                    </span>
                </div>
                <div class="form-group">
                    <label for="g_description" class="control-label col-sm-2">网站描述</label>
                    <div class="col-sm-5">
                        <textarea name="g_description" id="g_description" cols="10" rows="3" class="form-control"><?php echo $website['description'] ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="g_remark" class="control-label col-sm-2">备注</label>
                    <div class="col-sm-5">
                        <textarea name="g_remark" id="g_remark" cols="10" rows="3" class="form-control"><?php echo $website['remark'] ?></textarea>
                    </div>
                </div>
                <br/>
                <div class="form-group" style="text-align: center;">
                    <div class="col-sm-8"  style="margin-left: 30%;">
                        <div class="btn btn-success col-sm-4" id="update-website-ok">完成</div>
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
        $('.datepicker').datepicker({
         startDate: '-3d',
         dateFormat: 'yy-mm-dd'
        })
        $(".chzn_a").chosen({
            allow_single_deselect: true
        });
        //成功提示框设置
        $('#alert-success').modal({
            backdrop: false,
            show: false
        });
    

        $("#update-website-ok").on('click', function () {
            var flag = true;
            var g_id = $("#g_id").val();
            var g_name = $("#g_name").val();
            var g_type = $("#g_type").val();
            var g_domain = $("#g_domain").val();
            var g_hotline = $("#g_hotline").val();
            var g_qq = $("#g_qq").val();
            var g_expire_date = $("#g_expire_date").val();
            var g_description = $("#g_description").val();
            var g_remark = $("#g_remark").val();
           
            if (g_name == '' || g_name == undefined) {
                flag = flag & false;
                alertError("#alert-error", '网站名称不能为空！');
                return;
            }
            if (g_domain == '' || g_domain == undefined) {
                flag = flag & false;
                alertError("#alert-error", '域名不能为空！');
                return;
            }
            if (g_hotline == '' || g_hotline == undefined) {
                flag = flag & false;
                alertError("#alert-error", '电话不能为空！');
                return;
            }
            if (flag) {
                $.post('/website_manage/update_website_info',
                        {
                            id:g_id,name: g_name, type: g_type, 
                            domain: g_domain, hotline: g_hotline,qq:g_qq,
                            expire_date: g_expire_date, description: g_description,remark:g_remark
                        }, function (ret) {
                    var d = $.parseJSON(ret);
                    if (d.errCode == 0) {
                        alertSuccess("#alert-success", '/website_manage/website_list');
                    } else {
                        alertError("#alert-error", d.msg);
                    }
                });
            }

        });
    });
</script>
