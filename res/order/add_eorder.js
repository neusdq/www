$(document).ready(function () {
    //添加提示框
    $('#add-card-modal').modal({
        backdrop: 'static',
        show: false
    });

    //新建
    $(".add_card").click(function () {
        $("#add-card-modal").modal('show');
        $('#price').val('');
        $('#discount').val('');
        $('#book_count').val('');
        $('#sum_price').val('');
        $('#book_remark').val('');
        $('#giftBook').change(function () {
            $('.gift_show_price').html(13)
        })
        $("#giftcard-order-btn").die().live('click', function () {
            $(".alert-label-error").text('');
            var flag = true;
            var giftBook = $('#giftBook');
            var price = $('#price');
            var discount = $('#discount');
            var book_count = $('#book_count');
            var sum_price = $('#sum_price');
            var book_remark = $('#book_remark');
            var isNum = /^[0-9]*$/;
            if (giftBook.val() == '') {
                flag = flag & false;
                giftBook.parents('tr').find('.alert-label-error').html('请填写选择礼册');
            }
            
            if (price.val() == '' || price.val()==undefined) {
                flag = flag & false;
                price.parents('tr').find('.alert-label-error').html('请填单价');
            }

            if (discount.val() == '' ) {
                flag = flag & false;
                discount.parents('tr').find('.alert-label-error').html('请填写正确的折扣');
            }

            if (book_count.val() == '' || !isNum.test(book_count.val())) {
                flag = flag & false;
                book_count.parents('tr').find('.alert-label-error').html('请填写正确的数量');
            }

            if (sum_price.val() == '' || sum_price.val()==undefined) {
                flag = flag & false;
                sum_price.parents('tr').find('.alert-label-error').html('请填写正确的总价');
            }

            if (flag) {
                var gift_json = {};
                gift_json.gift_book_id = giftBook.val();
                gift_json.gift_book_name = $('.modal-body [value="' + giftBook.val() + '"]').html();
                gift_json.price = $.trim(price.val());
                gift_json.discount = $.trim(discount.val());
                gift_json.book_count = $.trim(book_count.val());
                gift_json.sum_price = $.trim(sum_price.val());
                gift_json.book_remark = $.trim(book_remark.val());
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
            tdStr += '<tr id="' + val.gift_book_id + '">'
            tdStr += '<td>' + val.gift_book_name + '</td>'
                    + '<td>' + val.price + '</td>'
                    + '<td>' + val.discount + '</td>'
                    + '<td>' + val.book_count + '</td>'
                    + '<td>' + val.sum_price + '</td>'
                    + '<td>' + val.book_remark + '</td>'
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


    $('#a_deal_date').datepicker({
        minDate: new Date(),
        dateFormat: "yy-mm-dd"
    });
    $('#a_expire_date').datepicker({
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
       for(i in gifts){
           if(gifts[i].id==$(this).val()){
                $("#price").val(gifts[i].sale_price);
            }
       }
    });
    
    //总价自动生成
    $("#sum_price").live('click',function(e){
       e.preventDefault();
       var price = $("#price").val();
       var discount = $("#discount").val();
       var book_count = $("#book_count").val();     
       $("#sum_price").val(price*discount*book_count/10);
    });

    $("#giftcard-order-ok").die().live('click', function () {
        var flag = true;
        var sales = $("#a_sales").val();
        var deal_date = $('#a_deal_date').val();
        var customer = $('#a_customer').val();
        var enduser = $('#a_enduser').val();
        var contact_person = $('#a_contact_person').val();
        var telephone = $('#a_telephone').val();
        var address = $('#a_address').val();
        var remark = $("#a_remark").val();
        
        var is_mobile = /^(?:13\d|15\d|18\d)\d{5}(\d{3}|\*{3})$/;
        var is_phone = /^((0\d{2,3})-)?(\d{7,8})(-(\d{3,}))?$/;
        
        if (sales == '' || sales == undefined) {
            flag = flag & false;
            alertError("#alert-error", '销售员不能为空！');
            return;
        }
        if (deal_date == '' || deal_date == undefined) {
            flag = flag & false;
            alertError("#alert-error", '交易日期不能为空！');
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
              
        if (!giftArr.length) {
            flag = flag & false;
            alertError("#alert-error", '请添加礼品册！');
            return;
        }

        if (flag) {
            $.post('/order_manage/save_eorder',
                {
                    sales: sales,
                    deal_date: deal_date,
                    customer: customer,
                    contact_person: contact_person,
                    enduser:enduser,
                    telephone: telephone,
                    address: address,
                    remark: remark,
                    gift_book_arr: giftArr
                }, function (ret) {
                    var d = $.parseJSON(ret);
                    if (d.errCode == 0) {
                        alertSuccess("#alert-success", '/order_manage/eorder_list');
                    } else {
                        alertError("#alert-error", d.msg);
                    }
            });
        }

    });
});

