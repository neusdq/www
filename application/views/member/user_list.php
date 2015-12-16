<!-- datatables -->
<link rel="stylesheet" href="<?php echo RES; ?>lib/datatables/extras/TableTools/media/css/TableTools.css">
<link rel="stylesheet" href="<?php echo RES; ?>/common/common.css" />
<?php $this->load->view('shared/upload-file-css'); ?>
<?php $this->load->view('shared/alert'); ?>

<div class="row">
    <div class="col-sm-12 col-md-12">
        <h3 class="heading">用户列表</h3>
        <div class="w-box-header">
            
            <div class="pull-left sort-disabled margin-left-2">
                <input name="s_id" class="input-medium form-control" placeholder="用户id" type="text">
            </div>
            
            <div class="pull-left sort-disabled margin-left-2">
                <input name="s_account" class="input-medium form-control" placeholder="用户账号" type="text">
            </div>
            
            <div class="pull-left sort-disabled margin-left-2">
                <input name="s_name" class="input-medium form-control" placeholder="用户名称" type="text">
            </div>
            
            <div class="pull-left sort-disabled margin-left-2">
                <input name="s_email" class="input-medium form-control" placeholder="用户邮箱" type="text">
            </div>
            
            <div class="pull-left sort-disabled margin-left-6">
                <button class="btn btn-success label search">查询</button>
            </div>
        </div>
        <div class="empty"></div>
        <div class="w-box-header">
            <div class="pull-left sort-disabled">
                <a class="btn btn-success label" id="add-user">新建</a>
            </div>
        </div>
        <table class="table table-striped table-bordered dTableR" id="user_tb">
            <thead>
                <tr>
                    <th class="center">用户id</th>
                    <th class="center">用户账号</th>
                    <th class="center">用户名称</th>
                    <th class="center">用户邮箱</th>
                    <th class="center">用户电话</th>
                    <th class="center">拥有角色</th>
                    <th class="center">操&nbsp;&nbsp;&nbsp;作</th>
                </tr>
            </thead>
            <tbody class="center">

            </tbody>        
        </table>
    </div>
</div>

<!---------新建弹层---------->
<div class="modal fade" id="add-user-modal">
    <div class="modal-dialog">
        <div class="modal-content" id="modal-max-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title">新建用户</h3>
            </div>
            <div class="modal-body">
                <table class="table table-condensed table-striped">
                    <tbody>
                        <tr>
                            <td class="center">用户名称</td>
                            <td>
                                <input name="a_name" type="text" class="form-control">
                            </td>
                            <td class="alert-label-error center" id="a-name-error"></td>
                        </tr>
                        <tr>
                            <td class="center">用户密码</td>
                            <td>
                                <input name="a_password" type="text" class="form-control">
                            </td>
                            <td class="alert-label-error center" id="a-password-error"></td>
                        </tr>
                        <tr>
                            <td class="center">用户姓名</td>
                            <td>
                                <input name="a_nickname" type="text" class="form-control">
                            </td>
                            <td class="alert-label-error center" id="a-nickname-error"></td>
                        </tr>
                        <tr>
                            <td class="center">用户邮箱</td>
                            <td>
                                <input name="a_email" type="text" class="form-control">
                            </td>
                            <td class="alert-label-error center" id="a-email-error"></td>
                        </tr>
                        <tr>
                            <td class="center">用户电话</td>
                            <td>
                                <input name="a_phone" type="text" class="form-control">
                            </td>
                            <td class="alert-label-error center" id="a-phone-error"></td>
                        </tr>
                        <tr>
                            <td class="center">角&nbsp;&nbsp;&nbsp;&nbsp;色</td>
                            <td>
                                <?php foreach($role as $k=>$v):?>
                                    <label class="checkbox-inline">
                                        <input value="<?php echo $k;?>" name="roles" type="checkbox"><?php echo $v;?>
                                    </label>
                                <?php endforeach;?>
                            </td>
                            <td class="alert-label-error center"></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="center">
                                <button type="button" class="btn btn-success" id="add-user-bnt">确认</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!---------编辑弹层---------->
<div class="modal fade" id="edit-user-modal">
    <div class="modal-dialog">
        <div class="modal-content" id="modal-max-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title">编辑用户</h3>
            </div>
            <div class="modal-body">
                <table class="table table-condensed table-striped">
                    <tbody>
                        <tr>
                            <td class="center">用户名称</td>
                            <td>
                                <span id="e_name" class="form-control"></span>
                                <input name="e_id" type="hidden" class="form-control">
                            </td>
                            <td class="alert-label-error center" id="e-name-error"></td>
                        </tr>
                        <tr>
                            <td class="center">用户姓名</td>
                            <td>
                                <input name="e_nickname" type="text" class="form-control">
                            </td>
                            <td class="alert-label-error center" id="e-nickname-error"></td>
                        </tr>
                        <tr>
                            <td class="center">用户邮箱</td>
                            <td>
                                <input name="e_email" type="text" class="form-control">
                            </td>
                            <td class="alert-label-error center" id="e-email-error"></td>
                        </tr>
                        <tr>
                            <td class="center">用户电话</td>
                            <td>
                                <input name="e_phone" type="text" class="form-control">
                            </td>
                            <td class="alert-label-error center" id="e-phone-error"></td>
                        </tr>
                        <tr>
                            <td class="center">角&nbsp;&nbsp;&nbsp;&nbsp;色</td>
                            <td>
                                <?php foreach($role as $k=>$v):?>
                                    <label class="checkbox-inline">
                                        <input value="<?php echo $k;?>" name="e_roles" type="checkbox"><?php echo $v;?>
                                    </label>
                                <?php endforeach;?>
                            </td>
                            <td class="alert-label-error center"></td>
                        </tr>
                        <tr>
                            <td class="alert-label-error center" id="e-error-info" colspan="3"></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="center">
                                <button type="button" class="btn btn-success" id="edit-user-bnt">确认</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
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

<?php $this->load->view('shared/upload-file'); ?>
<?php $this->load->view('shared/alert-upload'); ?>

<script src="<?php echo RES; ?>member/user_list.js"></script>

