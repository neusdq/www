
$(document).ready(function () {
    $('.datepicker').datepicker({
         startDate: '-3d',
         dateFormat: 'yy-mm-dd'
        })
    var ajax_source = "/order_manage/ajax_gift_list";
    //列表datatable
    var oTable = $('#gift_tb').dataTable({
        "sDom": "<'row'<'col-sm-6'f>r>t<'row'<'col-sm-2'<'dt_actions'>l><'col-sm-2'i><'col-sm-8'p>>",
        "sPaginationType": "bootstrap_alt",
        "bFilter": false, //禁止过滤
        "aaSorting": [[4, 'desc']], //默认排序
        "sAjaxSource": ajax_source,
        "bServerSide": true,
        "aoColumnDefs": [
            {
                "aTargets": [0, 1, 2, 3, 4, 5],
                "bSortable": false
            }
        ],
        "aoColumns": [
            {"mData": "checkbox"},
            {"mData": "gift_id"},
            {"mData": "gift_name"},
            {"mData": "sale_price"},
            {"mData": "store_num"},
            {"mData": "sold_num"}
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
    
    $("#add-porder-ok").die().live('click',function(){
            
            var flag = true;
            var card_num = $("#num_code").text();
            var gift_id = getCheckedIds()[0];
            var customer_name = $("#a_customer_name").val();
            var phone = $('#a_phone').val();
            var postcode = $("#a_postcode").val();
            var address = $("#a_address").val();
            var deliver_id = $("#a_deliver_id").val();
            var deliver_date = $("#a_deliver_date").val();
            var remark = $("#a_remark").val();               
            if(flag){
                $.post('/order_manage/save_porder',
                {
                    card_num:card_num,gift_id:gift_id,customer_name:customer_name,phone:phone,
                    postcode:postcode,address:address,deliver_id:deliver_id,deliver_date:deliver_date,remark:remark
                },function(ret){
                    var d = $.parseJSON(ret);
                    if(d.errCode==0){
                        alertSuccess("#alert-success",'/order_manage/order_list');
                    }else{
                        alertError("#alert-error",d.msg);
                    }
                });
            }
            
        });

});


