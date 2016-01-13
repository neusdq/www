
$(document).ready(function () {
  
    //号段生产提示框
    $('#create-giftcard-modal').modal({
        backdrop: 'static',
        show: false
    });
    
    var ajax_source = "/giftcard_manage/giftcard_inventory_page";
    //列表datatable
    var oTable = $('#giftcard-tb').dataTable({
        "sDom": "<'row'<'col-sm-6'f>r>t<'row'<'col-sm-2'<'dt_actions'>l><'col-sm-2'i><'col-sm-8'p>>",
        "sPaginationType": "bootstrap_alt",
        "bFilter": false, //禁止过滤
        "aaSorting": [[4, 'desc']], //默认排序
        "sAjaxSource": ajax_source,
        "bServerSide": true,
        "aoColumnDefs": [
            {
                "aTargets": [ 0, 2 ],
                "bSortable": false
            }
        ],
        "aoColumns": [
            {"mData": "num_code"},
            {"mData": "password"},
            {"mData": "status"},
            {"mData": "ctime"}
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
        params = "?code=" + encodeURIComponent($("input[name=s_code]").val())
                + "&status=" + encodeURIComponent($("select[name=s_status]").val())
                + "&scode=" + encodeURIComponent($("input[name=s_scode]").val())
                + "&ecode=" + encodeURIComponent($("input[name=s_ecode]").val())
                + "&date=" + encodeURIComponent($("input[name=s_date]").val());
        return params;
    }
  
    //下载商品
    $("#down-giftcard").click(function () {
        var download_url = '/giftcard_manage/download_giftcard' + getSearchParams();
        window.open(download_url);
    });
    
    $("#create-giftcard").click(function(){
        $("#crate-giftcard-error").html('');
        $("#create-giftcard-modal").modal('show');
    });
    
    $("#crate-giftcard-bnt").click(function(){
       var scode = $("input[name=a_scode]").val();
       var ecode = $("input[name=a_ecode]").val();
       if(scode=='' || scode==undefined){
           $("crate-giftcard-error").html('开始号码段不能为空');
           return false;
       }
       if(ecode=='' || ecode==undefined){
           $("crate-giftcard-error").html('结束号码段不能为空');
           return false;
       }
       $.post('/giftcard_manage/create_giftcard',{scode:scode,ecode:ecode},function(ret){
           var d = $.parseJSON(ret);
            if (d.errCode == 0) {
                $("#create-giftcard-modal").modal('hide');
                alertSuccess("#alert-success", '');
                var oSettings = oTable.fnSettings();
                oSettings.sAjaxSource = ajax_source + getSearchParams();
                oTable.fnDraw();
            } else {
                $("#create-giftcard-modal").modal('hide');
                alertError("#alert-error", d.msg);
            }
       });
    });
        
})

