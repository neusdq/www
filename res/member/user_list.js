
$(document).ready(function () {
    //添加提示框
    $('#add-user-modal').modal({
        backdrop: 'static',
        show: false
    });
    
    //编辑提示框
    $('#edit-user-modal').modal({
        backdrop: 'static',
        show: false
    });

    var ajax_source = "/member/user_list_page";
    //列表datatable
    var oTable = $('#user_tb').dataTable({
        "sDom": "<'row'<'col-sm-6'f>r>t<'row'<'col-sm-2'<'dt_actions'>l><'col-sm-2'i><'col-sm-8'p>>",
        "sPaginationType": "bootstrap_alt",
        "bFilter": false, //禁止过滤
        "aaSorting": [[0, 'desc']], //默认排序
        "sAjaxSource": ajax_source,
        "bServerSide": true,
        "aoColumnDefs": [
            {
                "aTargets": [1, 2, 3, 4, 5, 6],
                "bSortable": false
            }
        ],
        "aoColumns": [
            {"mData": "id"},
            {"mData": "account"},
            {"mData": "nick_name"},
            {"mData": "email"},
            {"mData": "phone"},
            {"mData": "role_name"},
            {"mData": "oper"}
        ],
        "oLanguage": {
            "sLengthMenu": "显示 _MENU_ ",
            "sInfo": "展示第 _START_ 到 _END_ 共_TOTAL_",
            "sProcessing": "正在查询...",
            "sZeroRecords": "抱歉，没找到相关记录",
            "oPaginate": {
                "sFirst": "首页",
                "sPrevious": "上一页",
                "sNext": "下一页",
                "sLast": "末页"
            },
        }
    });
    //查询
    $('button.search').die().live("click", function (e) {
        var oSettings = oTable.fnSettings();
        oSettings.sAjaxSource = ajax_source + getSearchParams();
        oTable.fnDraw();
    });

    /**
     * 获取查询条件呢
     * @returns {String}
     */
    function getSearchParams() {
        var params;
        params = "?id=" + $("input[name=s_id]").val()
                + "&name=" + encodeURIComponent($("input[name=s_name]").val())
                + "&account=" + $("input[name=s_account]").val()
                + "&email=" + $("input[name=s_email]").val();
        return params;
    }
    
    function getRole(){
        var checkedRole = $("input[name=roles]:checked");
        var roles = [];
        for (var i = 0; i < checkedRole.length; i++) {
            roles.push(checkedRole[i].value);
        }
        return roles;
    }
    
    function getEditRole(){
        var checkedRole = $("input[name=e_roles]:checked");
        var roles = [];
        for (var i = 0; i < checkedRole.length; i++) {
            roles.push(checkedRole[i].value);
        }
        return roles;
    }
    
    function setRole(roleStr){
        var roles = roleStr.split(',');
        var checkedRole = $("input[name=e_roles]");
        for (var i = 0; i < checkedRole.length; i++) {
            if($.inArray(checkedRole[i].value,roles)!=-1){
                checkedRole[i].checked = 'checked';
            }else{
                checkedRole[i].checked = false;
            }
        }
    }
    
    //新建
    $("#add-user").click(function(){
        $(".alert-label-error").text('');
        $("#add-user-modal").modal('show');
        $("#add-user-bnt").die().live('click',function(){
            $(".alert-label-error").text('');
            var flag = true;
            var name = $("input[name=a_name]").val();
            var passowrd = $("input[name=a_password]").val();
            var nickname = $("input[name=a_nickname]").val();
            var email = $("input[name=a_email]").val();
            var phone = $("input[name=a_phone]").val();
            var roles = getRole();
            var is_mobile = /^(?:13\d|15\d|18\d)\d{5}(\d{3}|\*{3})$/;   
            var is_phone = /^((0\d{2,3})-)?(\d{7,8})(-(\d{3,}))?$/;
            var is_email =  /^[a-z0-9-\_]+[\.a-z0-9_\-]*@([_a-z0-9\-]+\.)+([a-z]{2}|aero|arpa|biz|com|coop|edu|gov|info|int|jobs|mil|museum|name|nato|net|org|pro|travel)$/;
        
            if( name=='' ){
                flag = flag & false;
                $("#a-name-error").text('请填写用户名称！');
            }
            if( nickname=='' ){
                flag = flag & false;
                $("#a-nickname-error").text('请填写用户姓名！');
            }
            if( email=='' || !is_email.test(email)){
                flag = flag & false;
                $("#a-email-error").text('请填写正确的用户邮箱！');
            }
            if( passowrd=='' ){
                flag = flag & false;
                $("#a-passowrd-error").text('请填写用户密码！');
            }
            /*
            if( phone==''||(!is_mobile.test(phone) && !is_phone.test(phone)) ){
                flag = flag & false;
                $("#a-phone-error").text('请填写用户电话！');
            }
            */
            if(flag){
                $.post('/member/add_user?',{
                        name:name,password:passowrd,nickname:nickname,
                        email:email,phone:phone,roles:roles
                    },function(ret){
                    var d = $.parseJSON(ret);
                    $("#add-user-modal").modal('hide');
                    if (d.errCode==0) {
                         alertSuccess("#alert-success",'');
                         var oSettings = oTable.fnSettings();
                         oSettings.sAjaxSource = ajax_source + getSearchParams();
                         oTable.fnDraw();
                     } else {
                         alertError("#alert-error",d.msg);
                     }
                });
            }
        });
    })
    
    //编辑
    $("a.edit").die().live('click',function(){
        
        $("input[name=e_id]").val($(this).attr('rel'));
        $("#e_name").text($(this).parent().siblings().eq(1).text());
        $("input[name=e_nickname]").val($(this).parent().siblings().eq(2).text());
        $("input[name=e_email]").val($(this).parent().siblings().eq(3).text());
        $("input[name=e_phone]").val($(this).parent().siblings().eq(4).text());
        setRole($(this).attr('role'));
        $(".alert-label-error").text('');
        $("#edit-user-modal").modal('show');
        $("#edit-user-bnt").die().live('click',function(){
            $(".alert-label-error").text('');
            var flag = true;
            var id = $("input[name=e_id]").val();
            var nickname = $("input[name=e_nickname]").val();
            var email = $("input[name=e_email]").val();
            var phone = $("input[name=e_phone]").val();
            var roles = getEditRole();
            var is_mobile = /^(?:13\d|15\d|18\d)\d{5}(\d{3}|\*{3})$/;  
            var is_phone = /^((0\d{2,3})-)?(\d{7,8})(-(\d{3,}))?$/;
            var is_email =  /^[a-z0-9-\_]+[\.a-z0-9_\-]*@([_a-z0-9\-]+\.)+([a-z]{2}|aero|arpa|biz|com|coop|edu|gov|info|int|jobs|mil|museum|name|nato|net|org|pro|travel)$/;
        
            if( nickname=='' ){
                flag = flag & false;
                $("#e-nickname-error").text('请填写用户姓名！');
            }
            if( email=='' || !is_email.test(email)){
                flag = flag & false;
                $("#e-email-error").text('请填写正确的用户邮箱！');
            }
            if( phone==''||(!is_mobile.test(phone) && !is_phone.test(phone)) ){
                flag = flag & false;
                $("#e-phone-error").text('请填写用户电话！');
            }
           if(flag){
               $.post('/member/edit_user?',{
                   id:id,nickname:nickname,
                   email:email,phone:phone,roles:roles
               },function(ret){
                   var d = $.parseJSON(ret);
                   if (d.errCode==0) {
                        $("#edit-user-modal").modal('hide');
                        alertSuccess("#alert-success",'');
                        var oSettings = oTable.fnSettings();
                        oSettings.sAjaxSource = ajax_source + getSearchParams();
                        oTable.fnDraw();
                    } else {
                        $("#e-error-info").text(d.msg);
                    }
               });
            }
        });
    })
});


