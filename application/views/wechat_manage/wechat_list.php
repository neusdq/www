<!-- datatables -->
<link rel="stylesheet" href="<?php echo RES; ?>lib/datatables/extras/TableTools/media/css/TableTools.css">
<link rel="stylesheet" href="<?php echo RES; ?>/common/common.css" />
<?php $this->load->view('shared/alert'); ?>

<div class="row">
    <div class="col-sm-12 col-md-12">
        <h3 class="heading">微信模版列表</h3>
        <div class="w-box-header">
            <div class="pull-left sort-disabled margin-left-2">
                <input name="s_id" class="input-medium form-control" placeholder="模版id" type="text">
            </div>
            <div class="pull-left sort-disabled margin-left-2">
                <input name="s_name" class="input-medium form-control" placeholder="模版名称" type="text">
            </div>
            <div class="pull-left sort-disabled margin-left-2">
                <select name="s_style" class="select-medium form-control">
                    <option value="0">全部样式</option>
                    <option value="1">样式1</option>
                    <option value="2">样式2</option>
                </select>
            </div>  
            <div class="pull-left sort-disabled margin-left-2">
                <select name="s_status" class="select-medium form-control">
                    <option value="0">全部状态</option>
                    <option value="1">启用</option>
                    <option value="2">停用</option>
                </select>
            </div>
            <div class="pull-left sort-disabled margin-left-6">
                <button class="btn btn-success label search">查询</button>
            </div>
        </div>
        <div class="empty"></div>
        <div class="w-box-header">
            <div class="pull-left sort-disabled">
                <a class="btn btn-success label" href="/wechat_manage/add_wechat">新建</a>
                <a class="btn btn-success label margin-left-2" id="stop-wechat">停用</a>
                <a class="btn btn-success label margin-left-2" id="start-wechat">启用</a>
            </div>
        </div>
        <table class="table table-striped table-bordered dTableR" id="wechat_tb">
            <thead>
                <tr>
                    <th class="table_checkbox center">
                        <input name="select_rows" class="select_rows" data-tableid="wechat_tb" type="checkbox">
                    </th>
                    <th class="center">id</th>
                    <th class="center">模版名称</th>
                    <th class="center">样式</th>
                    <th class="center">视频id</th>
                    <th class="center">音频id</th>
                    <th class="center">图片id</th>
                    <th class="center">文案</th>
                    <th class="center">状态</th>
                    <th class="center">操作</th>
                </tr>
            </thead>
            <tbody class="center">

            </tbody>        
        </table>
    </div>
</div>

<!-- datatable -->
<script src="<?php echo RES; ?>lib/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo RES; ?>lib/datatables/extras/Scroller/media/js/dataTables.scroller.min.js"></script>
<!-- datatable table tools -->
<script src="<?php echo RES; ?>lib/datatables/extras/TableTools/media/js/TableTools.min.js"></script>
<script src="<?php echo RES; ?>lib/datatables/extras/TableTools/media/js/ZeroClipboard.js"></script>
<!-- datatables bootstrap integration -->
<script src="<?php echo RES; ?>lib/datatables/jquery.dataTables.bootstrap.min.js"></script>
<!-- datatable functions -->
<script src="<?php echo RES; ?>js/pages/gebo_datatables.js"></script>
<!-- tables functions -->
<script src="<?php echo RES; ?>js/pages/gebo_tables.js"></script>

<script src="<?php echo RES; ?>wechat/wechat_list.js"></script>


