
$(document).ready(function () {
    
    //成功提示框设置
    $('#alert-success').modal({
        backdrop: false,
        show: false
    });
    
    //选择监听
    $("li.checkbox").die().live('click',function(){
        $(this).siblings('li.checkbox').find('input[name=row_sel]').attr('checked',false);
    });
    
    $("#selected-goods-ok").click(function(){
        var orderid = $("input[name=r_orderid]").val();
        var gift_id = $("input[name=row_sel]:checked").val();
        var user = $("#r_user").val();
        var phone = $("#r_phone").val();
        var address = $("#r_address").val();
        var postcode = $("#r_postcode").val();
        var date = $("#r_date").val();
        var delivernum = $("#r_delivernum").val();
        var status = $("#r_status").val();
        var remark = $("#remark").val();
        var is_mobile = /^(?:13\d|15\d|18\d)\d{5}(\d{3}|\*{3})$/;
        var is_phone = /^((0\d{2,3})-)?(\d{7,8})(-(\d{3,}))?$/;
        
        var flag = true;
        if (user == '' || user == undefined) {
            flag = flag & false;
            alertError("#alert-error", '收件人不能为空！');
            return;
        }
        if (phone == '' || (!is_phone.test(phone)&&!is_mobile.test(phone))) {
            flag = flag & false;
            alertError("#alert-error", '请输入正确的手机号！');
            return;
        }
        if (address == '' || address == undefined) {
            flag = flag & false;
            alertError("#alert-error", '收货地址不能为空！');
            return;
        }
        if (postcode == '' || postcode == undefined) {
            flag = flag & false;
            alertError("#alert-error", '邮政编码不能为空！');
            return;
        }
        if (remark == '' || remark == undefined) {
            flag = flag & false;
            alertError("#alert-error", '备注不能为空！');
            return;
        }
        
        if(flag){
            $.post('/order_manage/do_edit_order'
            ,{
                orderid:orderid,delivernum:delivernum,
                card_id:$('input[name=r_cardid]').val(),
                card_num:$('input[name=r_codenum]').val(),
                gift_id:gift_id,customer_name:user,
                phone:phone,address:address,postcode:postcode,
                deliver_id:$('#r_deliver').val(),deliver_date:date,
                remark:remark,status:status
            },function(ret){
                var d = $.parseJSON(ret);
                if (d.errCode == 0) {
                    alertSuccess("#alert-success", '/order_manage/order_list');
                } else {
                    alertError("#alert-error", d.msg);
                }
            });
        }
        
    });
    
    
    
});


