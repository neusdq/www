
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

    var ajax_source = "/giftcard_manage/giftcard_order_list_page";
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
                "aTargets": [0, 1, 2, 3, 4, 5, 7, 8, 9, 10],
                "bSortable": false
            }
        ],
        "aoColumns": [
            {"mData": "checkbox"},
            {"mData": "trade_date"},
            {"mData": "sales"},
            {"mData": "customer"},
            {"mData": "modify_user"},
            {"mData": "order_name"},
            {"mData": "price"},
            {"mData": "pay_status"},
            {"mData": "pay_remark"},
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
        params = "?customer=" + encodeURIComponent($("input[name=s_customer]").val())
                + "&giftbook=" + encodeURIComponent($("input[name=s_giftbook]").val())
                + "&sales=" + encodeURIComponent($("input[name=s_sales]").val())
                + "&paystatus=" + encodeURIComponent($("select[name=s_paystatus]").val());
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
    
    //修改状态
    $("#edit-pay-status").die().live('click',function(){
        var ids = getCheckedIds();
        if(ids=='' || ids.length<1){
            alertError("#alert-error", '请选择要修改付款状态的记录');
            return false;
        }
        $("#e_paystatus_remark-error").text('');
        $("#update-giftcard-order-paystatus-modal").modal('show');
        
        $("#update-giftcard-order-status-bnt").die().live('click',function(){
            var paystatus = $("select[name=e_paystatus]").val();
            var pay_remark = $.trim($("textarea[name=e_paystatus_remark]").val());
            if( pay_remark=='' || pay_remark==undefined ){
                $("#e_paystatus_remark-error").text('修改付款状态备注不能为空！');
                return false;
            }
            
            $.post('/giftcard_manage/update_paystatus?', {ids: ids, paystatus: paystatus,pay_remark:pay_remark}
            , function (ret) {
                var d = $.parseJSON(ret);
                $("#update-giftcard-order-paystatus-modal").modal('hide');
                if (d.errCode == 0) {
                    alertSuccess("#alert-success", '');
                    var oSettings = oTable.fnSettings();
                    oSettings.sAjaxSource = ajax_source + getSearchParams();
                    oTable.fnDraw();
                } else {
                    alertError("#alert-error", d.msg);
                }
            });
        })
    });
    
    $("#edit-giftcard-order-bnt").die().live('click',function(){
        var id = $("input[name=e_orderid]").val();
        var sales = $("select[name=e_sales]").val();
        var customer = $("select[name=e_customer]").val();
        var enduser = $("input[name=e_enduser]").val();
        var remark = $("textarea[name=e_remark]").val();
        var wechat = $("select[name=e_wechat]").val();
        $.post('/giftcard_manage/edit_giftcard_order?', 
            { id:id, sales:sales,customer:customer,
              enduser:enduser, wechat:wechat,remark:remark
            }, function (ret) {
                var d = $.parseJSON(ret);
                $("#edit-giftcard-order-modal").modal('hide');
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
        $("input[name=e_orderid]").val($(this).attr('rel'));
        $("select[name=e_sales]").val($(this).attr('sales_id'));
        $("select[name=e_customer]").val($(this).attr('custom_id'));
        $("select[name=e_wechat]").val($(this).attr('wechat_id'));
        $("input[name=e_enduser]").val($(this).attr('end_user'));
        $("span[name=e_tradedate]").text($(this).attr('trade_date'));
        $("textarea[name=e_remark]").text($(this).parent().siblings().eq(9).text());
        var customer = $(this).attr('custom_id');
        
        for(i in customerArr){
           if(customerArr[i].id==customer){
                $("input[name=e_contact_person]").val(customerArr[i].name);
                $("input[name=e_phone]").val(customerArr[i].phone);
                $("input[name=e_address]").val(customerArr[i].address);
            }
       }
       $("#edit-giftcard-order-modal").modal('show');
    });
    
    $('a.ewm').die().live('click',function(){
        $("#ewm-modal div.modal-body").html($(this).attr('ewm_url'));
        $("#ewm-modal").modal('show');
    });
    
});


