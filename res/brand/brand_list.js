
$(document).ready(function () {
    //添加提示框
    $('#add-brand-modal').modal({
        backdrop: 'static',
        show: false
    });
    
    //编辑提示框
    $('#edit-brand-modal').modal({
        backdrop: 'static',
        show: false
    });

    var ajax_source = "/brand/brand_list_page";
    //列表datatable
    var oTable = $('#brand_tb').dataTable({
        "sDom": "<'row'<'col-sm-6'f>r>t<'row'<'col-sm-2'<'dt_actions'>l><'col-sm-2'i><'col-sm-8'p>>",
        "sPaginationType": "bootstrap_alt",
        "bFilter": false, //禁止过滤
        "aaSorting": [[4, 'desc']], //默认排序
        "sAjaxSource": ajax_source,
        "bServerSide": true,
        "aoColumnDefs": [
            {
                "aTargets": [0, 1, 2, 3, 5, 6],
                "bSortable": false
            }
        ],
        "aoColumns": [
            {"mData": "checkbox"},
            {"mData": "name"},
            {"mData": "id"},
            {"mData": "status"},
            {"mData": "goods_num"},
            {"mData": "remark"},
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
                + "&status=" + $("select[name=s_status]").val();
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
        var msg = '请选择要启用的品牌！';
        if (clickId == 'stop-brand') {
            status = 2;
            msg = '请选择要停用的品牌！';
        }
        var flag = true;
        var ids = getCheckedIds();
        if (ids == '') {
            flag = flag & false;
            alertError("#alert-error", msg);
            return;
        }
        if (flag) {
            $.post('/brand/update_brand?', {ids: ids, status: status}, function (ret) {
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
    $("#stop-brand").click(function () {
        downUpOper('stop-brand');
    });
    //下架
    $("#start-brand").click(function () {
        downUpOper('start-brand');
    });
    
    //新建
    $("#add-brand").click(function(){
        $("#add-brand-modal").modal('show');
        $("#add-brand-bnt").die().live('click',function(){
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
               $.post('/brand/add_brand?',{name:name,remark:remark},function(ret){
                   var d = $.parseJSON(ret);
                   $("#add-brand-modal").modal('hide');
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
        $("#edit-brand-modal").modal('show');
        $("#edit-brand-bnt").die().live('click',function(){
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
               $.post('/brand/edit_brand?',{
                   id:id,status:$("select[name=e_status]").val(),
                   name:name,remark:remark
               },function(ret){
                   var d = $.parseJSON(ret);
                   if (d.errCode==0) {
                        $("#edit-brand-modal").modal('hide');
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
    //导入
    $("a.load").die().live('click', function () {
        $("#load-classify-modal").modal('show');
        var params = 'id='+$(this).attr('rel');
         params += '&type=brand';
        $("#uploadButton").attr('params',params);
        var oSettings = oTable.fnSettings();
            oSettings.sAjaxSource = ajax_source + getSearchParams();
            oTable.fnDraw();
    });
});


