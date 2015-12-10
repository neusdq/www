<!-- datatables -->
<link rel="stylesheet" href="<?php echo RES; ?>lib/datatables/extras/TableTools/media/css/TableTools.css">
<link rel="stylesheet" href="<?php echo RES; ?>/common/common.css" />
<?php $this->load->view('shared/alert'); ?>

<div class="row">
    <div class="col-sm-12 col-md-12">
        <h3 class="heading">兑换网站列表</h3>
        <div class="w-box-header">
            <div class="pull-left sort-disabled margin-left-2">
                <input name="s_name" class="input-medium form-control" placeholder="网站名称" type="text">
            </div>
            <div class="pull-left sort-disabled margin-left-2">
                <input name="s_id" class="input-medium form-control" placeholder="网站id" type="text">
            </div>
            <div class="pull-left sort-disabled margin-left-2">
                <input name="s_domain" class="input-medium form-control" placeholder="网站域名" type="text">
            </div>
            <div class="pull-left sort-disabled margin-left-2">
                <select name="s_type" class="select-medium form-control">
                    <option value="0">全部类型</option>
                    <option value="1">兑换网站</option>
                    <option value="2">礼册商城</option>
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
                <a class="btn btn-success label" href="/website_manage/add_website">新建</a>
                <a class="btn btn-success label margin-left-2" id="stop-website">停用</a>
                <a class="btn btn-success label margin-left-2" id="start-website">启用</a>
            </div>
        </div>
        <table class="table table-striped table-bordered dTableR" id="website_tb">
            <thead>
                <tr>
                    <th class="table_checkbox center">
                        <input name="select_rows" class="select_rows" data-tableid="website_tb" type="checkbox">
                    </th>
                    <th class="center">网站id</th>
                    <th class="center">网站名称</th>
                    <th class="center">网站类型</th>
                    <th class="center">域名</th>
                    <th class="center">客服热线</th>
                    <th class="center">客服QQ</th>
                    <th class="center">有效期</th>
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

<script src="<?php echo RES; ?>website/website_list.js"></script>


