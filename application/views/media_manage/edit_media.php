<!-- multiselect -->
<link rel="stylesheet" href="<?php echo RES; ?>lib/multi-select/css/multi-select.css" />
<!-- enhanced select -->
<link rel="stylesheet" href="<?php echo RES; ?>lib/chosen/chosen.css" />

<?php $this->load->view('shared/upload-file-css'); ?>
<?php $this->load->view('shared/alert'); ?>

<div class="row">
    <div class="col-sm-12 col-md-12">
        <h3 class="heading">编辑多媒体</h3>
        <form class="form-horizontal" id="fileupload">
            <fieldset>
                <input name="g_id" id="g_id" type="hidden" value="<?php echo $media['id'] ?>">
                <div class="form-group">
                    <label for="g_name" class="control-label col-sm-2">名称</label>
                    <div class="col-sm-2">
                        
                        <input name="g_name" id="g_name" class="input-xlarge form-control" value="<?php echo $media['name']; ?>" type="text">
                    </div>
                    <label for="g_type" class="control-label col-sm-1">多媒体类型</label>
                    <div class="col-sm-2">
                        <select name="g_type" id="g_type" data-placeholder="多媒体类型..." class="chzn_a form-control">
                            <option value="1" <?php echo $media['type'] == 1 ? 'selected="selected"' : ''; ?>>图片</option>
                            <option value="2" <?php echo $media['type'] == 2 ? 'selected="selected"' : ''; ?>>音频</option>
                            <option value="3" <?php echo $media['type'] == 3 ? 'selected="selected"' : ''; ?>>视频</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="g_author" class="control-label col-sm-2">作者</label>
                    <div class="col-sm-2">
                        <input name="g_author" id="g_author" class="input-xlarge form-control" value="<?php echo $media['author']; ?>" type="text">
                    </div>
                    <label for="g_expire_date" class="control-label col-sm-2">有效期</label>
                    
                    <div class="col-sm-2">
                        <input name="g_expire_date" id="g_expire_date" class="datepicker" value="<?php echo $media['expire_date']; ?>" data-date-format="yy-mm-dd">                     
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
                        <input id="fileupload-img" type="file" name="files" multiple="" data-url="/upload_file/media_upload?" onclick="return checkUpload(5);">
                    </span>
                </div>
 
                <div class="form-group">
                    <label for="g_remark" class="control-label col-sm-2">备注</label>
                    <div class="col-sm-5">
                        <textarea name="g_remark" id="g_remark" cols="10" rows="3" class="form-control"><?php echo $media['remark']; ?></textarea>
                    </div>
                </div>
                <br/>
                <div class="form-group" style="text-align: center;">
                    <div class="col-sm-8"  style="margin-left: 30%;">
                        <div class="btn btn-success col-sm-4" id="update-media-ok">完成</div>
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
            show: false
        });
        $("span.delete").die().live('click',function(){
            $(this).parent().remove();
        })

        $("#update-media-ok").on('click', function () {
            var flag = true;
            var g_id = $("#g_id").val();
            var g_name = $("#g_name").val();
            var g_type = $("#g_type").val();
            var g_remark = $("#g_remark").val();
            var g_author = $("#g_author").val();
            var g_expire_date = $("#g_expire_date").val();
            var pic_ids = getUploadImg();
            var pic_num = pic_ids.split(',').length;
            if (g_name == '' || g_name == undefined) {
                flag = flag & false;
                alertError("#alert-error", '名称不能为空！');
                return;
            }
            if(pic_num>2){
                flag = flag & false;
                alertError("#alert-error", '不可传入多个文件！');
                return;
            }
            
            if (flag) {
                $.post('/media_manage/update_media_info',
                        {
                            id:g_id,name: g_name, type: g_type,remark:g_remark,
                            author: g_author, expire_date: g_expire_date,pic_ids:pic_ids
                            
                        }, function (ret) {
                    var d = $.parseJSON(ret);
                    if (d.errCode == 0) {
                        alertSuccess("#alert-success", '/media_manage/media_list');
                    } else {
                        alertError("#alert-error", d.msg);
                    }
                });
            }

        });
    });
</script>
