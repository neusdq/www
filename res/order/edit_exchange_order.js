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
            $.post('/order_manage/update_exchange_order',
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

