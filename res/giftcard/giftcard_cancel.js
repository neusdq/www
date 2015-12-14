$(document).ready(function () {
    //添加提示框
    $('#add-card-modal').modal({
        backdrop: 'static',
        show: false
    });

    //新建
    $(".add_card").click(function () {
        $("#add-card-modal").modal('show');
        $('#giftBook').change(function () {
            $('.gift_show_price').html(13)
        })
        $("#giftcard-order-btn").die().live('click', function () {
            $(".alert-label-error").text('');
            var flag = true;
            var start_num = $('#start_num');
            var end_num = $('#end_num');
            var isNum = /^[0-9]*$/;
            
            if (start_num.val() == '' || !isNum.test(start_num.val())) {
                flag = flag & false;
                start_num.parents('tr').find('.alert-label-error').html('请填写正确的开始号码');
            }

            if (end_num.val() == '' || !isNum.test(end_num.val())) {
                flag = flag & false;
                end_num.parents('tr').find('.alert-label-error').html('请填写正确的结束号码');
            }

            if (flag) {
                var gift_json = {};
                gift_json.start_num = $.trim(start_num.val());
                gift_json.end_num = $.trim(end_num.val());
                gift_json.num = Number(gift_json.end_num) - Number(gift_json.start_num) + 1;
                if(gift_json.num<=0){
                    end_num.parents('tr').find('.alert-label-error').html('结束号码段不能比开始的小！');
                    return ;
                }
                giftArr.push(gift_json);
                rendGiftList();
                $("#add-card-modal").modal('hide');
            }
        });
    })

    function inArray(arr, id) {
        var datakey = -1;
        $(arr).each(function (key, val) {
            if (val.gift_book_id == id) {
                datakey = key;
            }
        })
        return datakey;
    }

    function rendGiftList() {
        var tdStr = '';
        $(giftArr).each(function (key, val) {
            tdStr = '<tr>';
            tdStr += '<td>' + val.start_num + '</td>'
                   + '<td>' + val.end_num + '</td>'
                   + '<td>' + val.num + '</td>'
                   + '<td class=""><a rel="1" class="del_gift_list">删除</a></td>'
            tdStr += '</tr>'
        })
        $('#add_gift_list_tb tbody').html(tdStr);

        $('.del_gift_list').off('click').click(function () {
            var tr = $(this).parents('tr');
            var id = tr.attr('id');
            var inkey = inArray(giftArr, id);
            if (inkey != -1) {
                giftArr.splice(inkey, 1);
            }
            rendGiftList();
        })
    }


    $('#a_trade_date').datepicker({
        minDate: new Date(),
        dateFormat: "yy-mm-dd"
    });
    $('#a_expiration_date').datepicker({
        minDate: new Date(),
        dateFormat: "yy-mm-dd"
    });

    $(".chzn_a").chosen({
        allow_single_deselect: true
    });
    //成功提示框设置
    $('#alert-success').modal({
        backdrop: false,
        show: false
    });
    
    //客户选择监听
    $("#a_customer").live('change',function(e){
       e.preventDefault();
       for(i in customerArr){
           if(customerArr[i].id==$(this).val()){
                $("#a_contact_person").val(customerArr[i].name);
                $("#a_telephone").val(customerArr[i].phone);
                $("#a_address").val(customerArr[i].address);
            }
       }
    });
    
    //客户选择监听
    $("#giftBook").live('change',function(e){
       e.preventDefault();
       for(i in giftBook){
           if(giftBook[i].id==$(this).val()){
                $("#price").val(giftBook[i].sale_price);
            }
       }
    });

    $("#giftcard-order-ok").die().live('click', function () {
        var flag = true;
        var sales = $("#a_sales").val();
        var cancel_date = $('#a_cancel_date').val();
        var customer = $('#a_customer').val();
        var contact_person = $('#a_contact_person').val();
        var telephone = $('#a_telephone').val();
        var address = $('#a_address').val();
        var remark = $.trim($("textarea[name=a_remark]").val());
        var is_mobile = /^(?:13\d|15\d|18\d)\d{5}(\d{3}|\*{3})$/;
        var is_phone = /^((0\d{2,3})-)?(\d{7,8})(-(\d{3,}))?$/;
        
        if (sales == '' || sales == undefined) {
            flag = flag & false;
            alertError("#alert-error", '销售员不能为空！');
            return;
        }
        if (cancel_date == '' || cancel_date == undefined) {
            flag = flag & false;
            alertError("#alert-error", '退卡日期不能为空！');
            return;
        }
        if (customer == '' || customer == undefined) {
            flag = flag & false;
            alertError("#alert-error", '请选择客户！');
            return;
        }
        if (contact_person == '' || contact_person == undefined) {
            flag = flag & false;
            alertError("#alert-error", '联系人不能为空！');
            return;
        }

        if (telephone == '' || (!is_phone.test(telephone) && !is_mobile.test(telephone))) {
            flag = flag & false;
            alertError("#alert-error", '请输入正确的电话！');
            return;
        }

        if (address == '' || address == undefined) {
            flag = flag & false;
            alertError("#alert-error", '地址不能为空！');
            return;
        }
        if (remark == '' || remark == undefined) {
            flag = flag & false;
            alertError("#alert-error", '备注不能为空！');
            return;
        }
        
        if (!giftArr.length) {
            flag = flag & false;
            alertError("#alert-error", '请添加退卡段号！');
            return;
        }

        if (flag) {
            $.post('/giftcard_manage/do_cancel_giftcard',
                {
                    sales: sales,
                    cancel_date: cancel_date,
                    customer: customer,
                    contact_person: contact_person,
                    telephone: telephone,
                    address: address,
                    remark: remark,
                    code_arr: giftArr
                }, function (ret) {
                    var d = $.parseJSON(ret);
                    if (d.errCode == 0) {
                        alertSuccess("#alert-success", '/giftcard_manage/cancel_giftcard');
                    } else {
                        alertError("#alert-error", d.msg);
                    }
            });
        }

    });
});

