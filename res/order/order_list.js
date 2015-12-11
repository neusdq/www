
$(document).ready(function () {
    var ajax_source = "/order_manage/ajax_order_list";
    //列表datatable
        var oTable = $('#orderlist_tb').dataTable({
        "sDom": "<'row'<'col-sm-6'f>r>t<'row'<'col-sm-2'<'dt_actions'>l><'col-sm-2'i><'col-sm-8'p>>",
        "sPaginationType": "bootstrap_alt",
        "bFilter": false, //禁止过滤
        "aaSorting": [[4, 'desc']], //默认排序
        "sAjaxSource": ajax_source,
        "bServerSide": true,
        "aoColumnDefs": [
            {
                "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                "bSortable": false
            }
        ],
        "aoColumns": [
            {"mData": "checkbox"},
            {"mData": "id"},
            {"mData": "deliver_num"},
            {"mData": "deliver_id"},            
            {"mData": "gift_name"},
            {"mData": "customer_name"},
            {"mData": "phone"},
            {"mData": "address"},
            {"mData": "status"},
            {"mData": "order_source"},
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
            }
        }
    });
  

    //查询
    $('button.search').die().live("click", function (e) {
        var oSettings = oTable.fnSettings();
        oSettings.sAjaxSource = ajax_source + getSearchParams();
        alert();
        oTable.fnDraw();
    });

    /**
     * 获取查询条件呢
     * @returns {String}
     */
    function getSearchParams() {
        var params;
        params = "?id=" + $("input[name=s_id]").val()
                + "&deliver_num=" + encodeURIComponent($("input[name=s_deliver_num]").val())
                + "&customer_name=" + $("input[name=s_customer_name]").val()
                + "&book_id=" + encodeURIComponent($("input[name=s_book_id]").val())
                + "&status=" + encodeURIComponent($("input[name=s_status]").val())
                + "&order_source=" + encodeURIComponent($("input[name=s_order_source]").val());
        return params;
    }
        function getCheckedIds() {
        var ids = [],
                checkedInput = $("tbody input[name=row_sel]:checked");
        for (var i = 0; i < checkedInput.length; i++) {
            ids.push(checkedInput[i].id);
        }
        return ids;
    }

});


