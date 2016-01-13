<!-- multiselect -->
<link rel="stylesheet" href="<?php echo RES; ?>lib/multi-select/css/multi-select.css" />
<!-- enhanced select -->
<link rel="stylesheet" href="<?php echo RES; ?>lib/chosen/chosen.css" />
<link rel="stylesheet" href="<?php echo RES; ?>lib/datepicker/bootstrap-datepicker.min.css" />
<?php $this->load->view('shared/upload-file-css'); ?>
<?php $this->load->view('shared/alert'); ?>
<div class="row">
    <div class="col-sm-12 col-md-12">
        <h3 class="heading">新建网站</h3>
        <form class="form-horizontal" id="fileupload">
            <fieldset>
                <div class="form-group">
                    <label for="a_name" class="control-label col-sm-2">网站名称</label>
                    <div class="col-sm-2">
                        <input name="a_name" id="a_name" class="input-xlarge form-control" value="" type="text">
                    </div>
                    <label for="a_type" class="control-label col-sm-1">网站类型</label>
                    <div class="col-sm-2">
                        <select name="a_type" id="a_type" data-placeholder="选择类型..." class="chzn_a form-control">
                            <option value="1" selected="selected">兑换网站</option>
                            <option value="2">礼册商场</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="a_domain" class="control-label col-sm-2">绑定域名</label>
                    <div class="col-sm-2">
                        <input name="a_domain" id="a_domain" class="input-xlarge form-control" value="" type="text">
                    </div>
                    <label for="a_hotline" class="control-label col-sm-1">客服热线</label>
                    <div class="col-sm-2">
                        <input name="a_hotline" id="a_hotline" class="input-xlarge form-control" value="" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="a_qq" class="control-label col-sm-2">客服QQ</label>
                    <div class="col-sm-2">
                        <input name="a_qq" id="a_qq" class="input-xlarge form-control" value="" type="text">
                    </div>
                    <label for="a_expire_date" class="control-label col-sm-2">有效期</label>
                    
                    <div class="col-sm-2">
                        <input name="a_expire_date" id="a_expire_date" class="datepicker" data-date-format="yy-mm-dd">                     
                    </div>
                </div>
                <div class="form-group">
                    <label for="fileinput" class="control-label col-sm-2">上传文件</label>
                    <!-- The table listing the files available for upload/download -->
                    <span role="presentation" class="table table-striped">
                        <ul class="files">
                            
                        </ul>
                    </span>
                    <span class="btn btn-success fileinput-button" id="fileupload-bnt" title="上传文件">
                        <i class="glyphicon glyphicon-plus"></i>
                        <!-- The file input field used as target for the file upload widget -->
                        <input id="fileupload-img" type="file" name="files" multiple="" data-url="/upload_file/img_upload?" onclick="return checkUpload(5);">
                    </span>
                </div>
                <div class="form-group">
                    <label for="a_description" class="control-label col-sm-2">网站描述</label>
                    <div class="col-sm-5">
                        <textarea name="a_description" id="a_description" cols="10" rows="3" class="form-control"></textarea>
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
                        <div class="btn btn-success col-sm-4" id="add-website-ok">完成</div>
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
    var upload_path = "<?php echo UPLOAD; ?>";
    $('#fileupload-img').fileupload({
        formData: {script: true}
        , add: function (e, data) {
            data.submit();
        }
        , done: function (e, data) {
            if(data.result.errCode==0){
                var file_name = data.result.val.name;
                var file_id = data.result.val.id;
                var file_path = upload_path + data.result.val.path;
                var html = '<li class="template-download fade none-list-style in">';
                    html += '<p class="preview">';
                    html += '<a href="'+file_path+ file_name+'" target="_blank" class="img-uploaded" title="'+file_name+'" >';
                    html += '<img src="'+file_path+'thumb_'+file_name+'">';
                    html += '</a></p>';
                    html += '<span class="delete text-center btn-danger img-uploaded" id="'+file_id+'">删除</span>';
                    html += '</li>';
                $("ul.files").append(html);
            }else{
                alertError("#alert-error",'文件上传失败');
            }
        }
    });

</script>
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
            show:false
        });
        $("span.delete").die().live('click',function(){
            $(this).parent().remove();
        })
        
        $("#add-website-ok").die().live('click',function(){
            var flag = true;
            var name = $("#a_name").val();
            var type = $('#a_type').val();     
            var domain = $("#a_domain").val(); //联系人
            var hotline = $("#a_hotline").val();    
            var qq = $("#a_qq").val();   //邮编
            var expire_date = $("#a_expire_date").val();
            var pic_id = getUploadImg().split(',')[0]; 
            
            //var pic_id=0;
            var description = $("#a_description").val();
            var remark = $("#a_remark").val();
            if(name=='' || name==undefined){
                flag = flag & false;
                alertError("#alert-error",'网站名称不能为空！');
                return ;
            }
            if(domain=='' || domain==undefined){
                flag = flag & false;
                alertError("#alert-error",'域名不能为空！');
                return ;
            }
            if(hotline=='' || hotline==undefined){
                flag = flag & false;
                alertError("#alert-error",'热线电话不能为空！');
                return ;
            }
            if(flag){
                $.post('/website_manage/add_website',
                {
                    name:name,type:type,
                    domain:domain,hotline:hotline,qq:qq,
                    expire_date:expire_date,pic_id:pic_id,description:description,
                    remark:remark
                },function(ret){
                    var d = $.parseJSON(ret);
                    if(d.errCode==0){
                        alertSuccess("#alert-success",'/business_manage/website_list');
                    }else{
                        alertError("#alert-error",d.msg);
                    }
                });
            }
            
        });
    });
</script>
