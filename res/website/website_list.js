
$(document).ready(function () {
    //添加提示框
    $('#add-website-modal').modal({
        backdrop: 'static',
        show: false
    });
    
    //编辑提示框
    $('#edit-website-modal').modal({
        backdrop: 'static',
        show: false
    });

    var ajax_source = "/website_manage/website_list_page";
    //列表datatable
    var oTable = $('#website_tb').dataTable({
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
            {"mData": "type"},
            {"mData": "domain"},
            {"mData": "hotline"},
            {"mData": "qq"},
            {"mData": "expire_date"},
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
                + "&domain=" + encodeURIComponent($("input[name=s_domain]").val())
                + "&type=" + $("select[name=s_type]").val();
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
        var msg = '请选择要启用的网站！';
        if (clickId == 'stop-website') {
            status = 2;
            msg = '请选择要停用的网站！';
        }
        var flag = true;
        var ids = getCheckedIds();
        if (ids == '') {
            flag = flag & false;
            alertError("#alert-error", msg);
            return;
        }
        if (flag) {
            $.post('/website_manage/update_status?', {ids: ids, status: status}, function (ret) {
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
    $("#stop-website").click(function () {
        downUpOper('stop-website');
    });
    //下架
    $("#start-website").click(function () {
        downUpOper('start-website');
    });
    
});


