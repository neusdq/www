$(document).ready(function () {
    var from_gift;
    $(".chzn_a").chosen({
        allow_single_deselect: true
    });
    //成功提示框设置
    $('#alert-success').modal({
        backdrop: false,
        show: false
    });
    $("#search_order").die().live('click', function () {
        var flag = true;
        var order_id = $("#order_id").val();
        if (flag) {
            $.post('/order_manage/search_exorder_info',
                    {
                        order_id: order_id
                    }, function (ret) {
                var d = $.parseJSON(ret);
                if (d.errCode == 0) {
                    from_gift = d.val['order_info']['gift_id'];
                    $("#card_num").val(d.val['order_info']['card_num']);
                    $("#price").val(d.val['order_info']['sale_price']);
                    $("#gift_book").val(d.val['order_info']['book_name']);
                    $("#gift").val(d.val['order_info']['gift_name']);
                    $("#customer").val(d.val['order_info']['customer_name']);
                    $("#phone").val(d.val['order_info']['phone']);
                    $("#deal_date").val(d.val['order_info']['ctime']);
                    $("#address").val(d.val['order_info']['address']);
                    //$("#exchange_gift").append("<option value='Value'>Text</option>");
                    for (i in d.val['gift_arr']){
                        $("#exchange_gift").append("<option value='"+d.val['gift_arr'][i]['id']+"'>"+d.val['gift_arr'][i]['name']+"</option>");
                    }

                } else {
                    alertError("#alert-error", d.msg);
                }
            });
        }

    }
    )
    $("#add-exorder-ok").die().live('click', function () {
        var flag = true;
        var order_id = $("#order_id").val();
        var exchange_gift = $("#exchange_gift").val();
        var diliver_money = $("#diliver_money").val();
        var remark = $("#remark").val();
        var isNum = /^[0-9]*$/;

        if (order_id == '' || order_id == undefined) {
            flag = flag & false;
            alertError("#alert-error", '订单不能为空！');
            return;
        }
        if (diliver_money == '' || !isNum.test(diliver_money)) {
            flag = flag & false;
            alertError("#alert-error", '请输入正确的快递费用！');
            return;
        }
        if (flag) {
            $.post('/order_manage/save_exchange_order',
                    {
                        order_id: order_id,
                        from_gift:from_gift,
                        to_gift: exchange_gift,
                        diliver_money: diliver_money,
                        remark: remark
                    }, function (ret) {
                var d = $.parseJSON(ret);
                if (d.errCode == 0) {
                    alertSuccess("#alert-success", '/order_manage/rorder_list');
                } else {
                    alertError("#alert-error", d.msg);
                }
            });
        }

    });
});

