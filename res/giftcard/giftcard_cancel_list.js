
$(document).ready(function () {
    //修改付款状态提示框
    $('#update-giftcard-order-paystatus-modal').modal({
        backdrop: 'static',
        show: false
    });
    
    //编辑提示框
    $('#edit-giftcard-order-modal').modal({
        backdrop: 'static',
        show: false
    });
    
    //二维码框
    $('#ewm-modal').modal({
        backdrop: 'static',
        show: false
    });
    
    //客户选择监听
    $("select[name=e_customer]").live('change',function(e){
       e.preventDefault();
       for(i in customerArr){
           if(customerArr[i].id==$(this).val()){
                $("input[name=e_contact_person]").val(customerArr[i].name);
                $("input[name=e_phone]").val(customerArr[i].phone);
                $("input[name=e_address]").val(customerArr[i].address);
            }
       }
    });

    var ajax_source = "/giftcard_manage/cancel_giftcard_page?";
    //列表datatable
    var oTable = $('#giftcard-order_tb').dataTable({
        "sDom": "<'row'<'col-sm-6'f>r>t<'row'<'col-sm-2'<'dt_actions'>l><'col-sm-2'i><'col-sm-8'p>>",
        "sPaginationType": "bootstrap_alt",
        "bFilter": false, //禁止过滤
        "aaSorting": [[4, 'desc']], //默认排序
        "sAjaxSource": ajax_source,
        "bServerSide": true,
        "aoColumnDefs": [
            {
                "aTargets": [0, 2, 3, 4, 5, 7, 8],
                "bSortable": false
            }
        ],
        "aoColumns": [
            {"mData": "checkbox"},
            {"mData": "cancel_date"},
            {"mData": "sales"},
            {"mData": "customer"},
            {"mData": "end_user"},
            {"mData": "modify_user"},
            {"mData": "cancel_num"},
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
        params = "sales=" + encodeURIComponent($("input[name=s_sales]").val())
               + "&sdate=" + encodeURIComponent($("input[name=s_sdate]").val())
               + "&edate=" + encodeURIComponent($("input[name=s_edate]").val());
        return params;
    }

    $("#edit-cancel-giftcard-bnt").die().live('click',function(){
        var id = $("input[name=e_id]").val();
        var sales = $("select[name=e_sales]").val();
        var customer = $("select[name=e_customer]").val();
        var enduser = $("input[name=e_enduser]").val();
        var remark = $("textarea[name=e_remark]").val();
        $.post('/giftcard_manage/edit_cancel_giftcard?', 
            { id:id, sales:sales,customer:customer,
              enduser:enduser,remark:remark
            }, function (ret) {
                var d = $.parseJSON(ret);
                $("#edit-cancel-giftcard-modal").modal('hide');
                if (d.errCode == 0) {
                    alertSuccess("#alert-success", '');
                    var oSettings = oTable.fnSettings();
                    oSettings.sAjaxSource = ajax_source + getSearchParams();
                    oTable.fnDraw();
                } else {
                    alertError("#alert-error", d.msg);
                }
        });
        
    });
    
    $("a.edit").die().live('click',function(){
        $("input[name=e_id]").val($(this).attr('rel'));
        $("select[name=e_sales]").val($(this).attr('sales_id'));
        $("select[name=e_customer]").val($(this).attr('custom_id'));
        $("input[name=e_enduser]").val($(this).attr('end_user'));
        $("span[name=e_canceldate]").text($(this).attr('cancel_date'));
        $("textarea[name=e_remark]").text($(this).parent().siblings().eq(7).text());
        var customer = $(this).attr('custom_id');
        
        for(i in customerArr){
           if(customerArr[i].id==customer){
                $("input[name=e_contact_person]").val(customerArr[i].name);
                $("input[name=e_phone]").val(customerArr[i].phone);
                $("input[name=e_address]").val(customerArr[i].address);
            }
       }
       $("#edit-cancel-giftcard-modal").modal('show');
    });
    
});





