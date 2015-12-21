$(document).ready(function () {

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
            $.post('/order_manage/search_order_info',
                    {
                        order_id: order_id
                    }, function (ret) {
                var d = $.parseJSON(ret);
                if (d.errCode == 0) {
                    $("#card_num").val(d.val['card_num']);
                    $("#price").val(d.val['sale_price']);
                    $("#gift_book").val(d.val['book_name']);
                    $("#gift").val(d.val['gift_name']);
                    $("#customer").val(d.val['customer_name']);
                    $("#phone").val(d.val['phone']);
                    $("#deal_date").val(d.val['ctime']);
                    $("#address").val(d.val['address']);

                } else {
                    alertError("#alert-error", d.msg);
                }
            });
        }

    }
    )
    $("#add-rorder-ok").die().live('click', function () {
        var flag = true;
        var order_id = $("#order_id").val();
        var return_amount= $("#return_amount").val();
        var bank= $("#bank").val();
        var open_bank_address= $("#open_bank_address").val();
        var bank_card_num= $("#bank_card_num").val();
        var bank_card_name= $("#bank_card_name").val();
        var remark= $("#remark").val();
        var isNum = /^[0-9]*$/;

        if (order_id == '' || order_id == undefined) {
            flag = flag & false;
            alertError("#alert-error", '订单不能为空！');
            return;
        }
        if (return_amount == '' || !isNum.test(return_amount)) {
            flag = flag & false;
            alertError("#alert-error", '请输入正确的金额数字！');
            return;
        }
        if (bank == '' || bank == undefined) {
            flag = flag & false;
            alertError("#alert-error", '请选择银行！');
            return;
        }
        if (open_bank_address == '' || open_bank_address == undefined) {
            flag = flag & false;
            alertError("#alert-error", '开户行不能为空！');
            return;
        }
        if (bank_card_num == '' || bank_card_num == undefined) {
            flag = flag & false;
            alertError("#alert-error", '请输入正确的账号！');
            return;
        }

        if (bank_card_name == '' || bank_card_name == undefined) {
            flag = flag & false;
            alertError("#alert-error", '请输入开户名！');
            return;
        }

        if (flag) {
            $.post('/order_manage/save_return_order',
                    {
                        order_id: order_id,
                        return_amount: return_amount,
                        bank: bank,
                        open_bank_address: open_bank_address,
                        bank_card_num: bank_card_num,
                        bank_card_name: bank_card_name,
                        remark:remark
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

