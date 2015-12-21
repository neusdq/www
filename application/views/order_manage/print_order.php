<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>订单出库</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            #card-info,#card-info>tbody,#card-info>tbody>tr,#card-info>tbody>tr>td{
                border: 1px solid;
            }
            #card-info>thead>tr>th,#card-info>tbody>tr>td{padding: 6px 12px;}
        </style>
    </head>
    <body>
        <div style="text-align: center;">
            <table id="card-info" cellspacing="0" cellpadding="0" style="margin: auto;">
                <thead>
                    <tr>
                        <th colspan="4" class="center">
                            <h1>北京蓝卡风尚文化发展有限公司</h1>
                        </th>
                    </tr>
                    <tr>
                        <th colspan="4" class="center">入&nbsp;库&nbsp;单</th>
                    </tr>
                </thead>
                
                <tbody>
                    <tr>
                        <td class="center">申请部门</td>
                        <td class="center"></td>
                        <td class="center">经手人</td>
                        <td class="center"></td>
                    </tr>
                    <tr>
                        <td class="center">礼品编号</td>
                        <td class="center">礼品名称</td>
                        <td class="center"></td>
                        <td class="center">数量</td>
                    </tr>
                    <tr>
                        <?php foreach($gift as $v):?>
                            <td class="center"><?php echo $v['id']; ?></td>
                            <td class="center"><?php echo $v['name']; ?></td>
                            <td class="center"></td>
                            <td class="center"><?php echo '1'; ?></td>
                        <?php endforeach;?>
                    </tr>
                    <tr>
                        <td class="center">收货方</td>
                        <td class="center" colspan="3"><?php echo $order['customer_name'];?></td>
                    </tr>
                    <tr>
                        <td class="center">收货地址</td>
                        <td class="center" colspan="3"><?php echo $order['address'];?></td>
                    </tr>
                    <tr>
                        <td class="center">快递单号</td>
                        <td class="center" colspan="3"><?php echo $order['deliver_num'];?></td>
                    </tr>
                    <tr>
                        <td class="center">备注</td>
                        <td class="center" colspan="3"><?php echo $order['remark'];?></td>
                    </tr>
                    <tr>
                        <td class="center">电商运营部</td>
                        <td class="center" colspan="3"></td>
                    </tr>
                    <tr>
                        <td class="center">仓储物流部</td>
                        <td class="center" colspan="3"></td>
                    </tr>
                    <tr>
                        <td class="center">财务中心</td>
                        <td class="center" colspan="3"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>  
</html>
