<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>销售订单</title>
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
        <div>
            <table id="card-info" cellspacing="0" cellpadding="0" border="0" style="margin: auto;">
                <thead>
                    <tr>
                        <th colspan="8">
                            <h1>北京蓝卡风尚文化发展有限公司</h1>
                        </th>
                    </tr>
                    <tr>
                        <th colspan="8">销&nbsp;售&nbsp;退&nbsp;单</th>
                    </tr>
                    <tr>
                        <th>录入人:</th>
                        <th colspan="2" style="text-align: left;"><?php echo isset($order['modify_user'])?$order['modify_user']:''?></th>
                        <th>销售员:</th>
                        <th colspan="1" style="text-align: left;"><?php echo isset($order['user_name'])?$order['user_name']:''?></th>
                        <th>销售日期:</th>
                        <th colspan="2" style="text-align: left;"><?php echo isset($order['trade_date'])?$order['trade_date']:''?></th>
                    </tr>
                    <tr>
                        <th colspan="8">客户信息</th>
                    </tr>
                </thead>
                
                <tbody>
                    <tr>
                        <td colspan="8">公司名称：</td>
                    </tr>
                    <tr>
                        <td colspan="8">最终客户：<?php echo isset($order['end_user'])?$order['end_user']:''?></td>
                    </tr>
                    <tr>
                        <td colspan="2">联系人</td>
                        <td colspan="2">联系电话</td>
                        <td colspan="4">地址</td>
                    </tr>
                    <tr>
                        <td colspan="2"><?php echo isset($order['contact_person'])?$order['contact_person']:''?></td>
                        <td colspan="2"><?php echo isset($order['phone'])?$order['phone']:''?></td>
                        <td colspan="4"><?php echo isset($order['address'])?$order['address']:''?></td>
                    </tr>
                    <tr>
                        <td class="center">编号</td>
                        <td class="center">名称</td>
                        <td class="center">号段</td>
                        <td class="center">数量</td>
                        <td class="center">单价</td>
                        <td class="center">折扣</td>
                        <td class="center">折后单价</td>
                        <td class="center">金额</td>
                    </tr>
                    <?php $total=0;$money_total=0;?>
                    <?php foreach($book as $v):?>
                    <tr>
                        <td class="center"><?php echo $v['book_id'];?></td>
                        <td class="center"><?php echo $v['book_name'];?></td>
                        <td class="center"><?php echo $v['scode'].'--'.$v['ecode'];?></td>
                        <td class="center"><?php echo $v['num'];?></td>
                        <td class="center"><?php echo $v['price'];?></td>
                        <td class="center"><?php echo $v['discount'];?></td>
                        <td class="center"><?php echo $end_price = $v['discount']?(round($v['price']*$v['discount']/10,2)):$v['price'];?></td>
                        <td class="center"><?php echo $rmb = $v['num']*$end_price;?></td>
                        <?php $total+=$v['num'];$money_total+=$rmb;?>
                    </tr>
                    <?php endforeach;?>
                    <tr>
                        <td colspan="3">合计：</td>
                        <td class="center"><?php echo $total;?></td>
                        <td class="center"></td>
                        <td class="center"></td>
                        <td class="center"></td>
                        <td class="center"><?php echo $money_total;?></td>
                    </tr>
                    <tr>
                        <td colspan="8">合计金额(大写):<?php echo rmb($money_total);?></td>
                    </tr>
                    <tr>
                        <td colspan="4">销售签字:</td>
                        <td colspan="4">客户签字:</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>  
</html>
