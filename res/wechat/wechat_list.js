
$(document).ready(function () {
    //添加提示框
    $('#add-wechat-modal').modal({
        backdrop: 'static',
        show: false
    });
    
    //编辑提示框
    $('#edit-wechat-modal').modal({
        backdrop: 'static',
        show: false
    });

    var ajax_source = "/wechat_manage/wechat_list_page";
    //列表datatable
    var oTable = $('#wechat_tb').dataTable({
        "sDom": "<'row'<'col-sm-6'f>r>t<'row'<'col-sm-2'<'dt_actions'>l><'col-sm-2'i><'col-sm-8'p>>",
        "sPaginationType": "bootstrap_alt",
        "bFilter": false, //禁止过滤
        "aaSorting": [[4, 'desc']], //默认排序
        "sAjaxSource": ajax_source,
        "bServerSide": true,
        "aoColumnDefs": [
            {
                "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                "bSortable": false
            }
        ],
        "aoColumns": [
            {"mData": "checkbox"},
            {"mData": "id"},
            {"mData": "name"},
            {"mData": "style"},
            {"mData": "vedio_id"},
            {"mData": "audio_id"},
            {"mData": "pic_id"},
            {"mData": "copywriter"},
            {"mData": "status"},
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
                + "&status=" + $("select[name=s_status]").val()
                + "&style=" + encodeURIComponent($("input[name=s_style]").val());
        return params;
    }

    /**
     * 获取选中的商品id
     * @returns {Array}
     */
    function getCheckedIds() {
        var ids = [],
                checkedInput = $("tbody input[name=row_sel]:checked");
        for (var i = 0; i < checkedInput.length; i++) {
            ids.push(checkedInput[i].id);
        }
        return ids;
    }

    //停用和启动操作
    function downUpOper(clickId) {
        var status = 1;
        var msg = '请选择要启用的礼册！';
        if (clickId == 'stop-wechat') {
            status = 2;
            msg = '请选择要停用的礼册！';
        }
        var flag = true;
        var ids = getCheckedIds();
        if (ids == '') {
            flag = flag & false;
            alertError("#alert-error", msg);
            return;
        }
        if (flag) {
            $.post('/wechat_manage/update_wechat?', {ids: ids, status: status}, function (ret) {
                var d = $.parseJSON(ret);
                if (d.errCode == 0) {
                    alertSuccess("#alert-success", '');
                    var oSettings = oTable.fnSettings();
                    oSettings.sAjaxSource = ajax_source + getSearchParams();
                    oTable.fnDraw();
                } else {
                    alertError("#alert-error", d.msg);
                }
            });
        }
    }
    //上架
    $("#stop-wechat").click(function () {
        downUpOper('stop-wechat');
    });
    //下架
    $("#start-wechat").click(function () {
        downUpOper('start-wechat');
    });
    
    //新建
    $("#add-wechat").click(function(){
        $("#add-wechat-modal").modal('show');
        $("#add-wechat-bnt").die().live('click',function(){
            $(".alert-label-error").text('');
            var flag = true;
            var name = $("input[name=a_name]").val();
            var remark = $("textarea[name=a_remark]").val();
           if( name=='' ){
               flag = flag & false;
               $("#name-error").text('请填写品牌名称！');
           }
           if( remark=='' ){
               flag = flag & false;
               $("#remark-error").text('请填写备注！');
           }
           if(flag){
               $.post('/wechat_manage/add_wechat?',{name:name,remark:remark},function(ret){
                   var d = $.parseJSON(ret);
                   $("#add-wechat-modal").modal('hide');
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
        $("span[name=e_id]").text($(this).parent().siblings().eq(2).text());
        $("input[name=e_name]").val($(this).parent().siblings().eq(1).text());
        var status = 1;
        if($(this).parent().siblings().eq(3).text()=='停用'){
            var status = 2;
        }
        $("select[name=e_status]").val(status);
        $("textarea[name=e_remark]").val($(this).parent().siblings().eq(5).text());
        $("#edit-wechat-modal").modal('show');
        $("#edit-wechat-bnt").die().live('click',function(){
            $(".alert-label-error").text('');
            var flag = true;
            var name = $("input[name=e_name]").val();
            var remark = $("textarea[name=e_remark]").val();
            var id = $("span[name=e_id]").text();
           if( name=='' ){
               flag = flag & false;
               $("#edit-name-error").text('请填写品牌名称！');
           }
           if( remark=='' ){
               flag = flag & false;
               $("#edit-remark-error").text('请填写备注！');
           }
           if(flag){
               $.post('/wechat_manage/edit_wechat?',{
                   id:id,status:$("select[name=e_status]").val(),
                   name:name,remark:remark
               },function(ret){
                   var d = $.parseJSON(ret);
                   if (d.errCode==0) {
                        $("#edit-wechat-modal").modal('hide');
                        alertSuccess("#alert-success",'');
                        var oSettings = oTable.fnSettings();
                        oSettings.sAjaxSource = ajax_source + getSearchParams();
                        oTable.fnDraw();
                    } else {
                        $("#edit-status-error").text(d.msg);
                    }
               });
            }
        });
    })

});


