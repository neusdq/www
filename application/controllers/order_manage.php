<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of order_manage
 * 订单管理
 */
class order_manage extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('customer_model');
        $this->load->model('giftbook_model');
        $this->load->model('order_model');
        $this->load->model('deliver_model');
        $this->load->model('user_model');
        $this->load->model('goods_manage_model');
        $this->load->library('Data_table_parser');
        $this->data_table_parser->set_db($this->db);
        $this->load->library('uc_service', array('cfg' => $this->config->item('alw_uc')));
    }

    /**
     * 增加电话兑换订单入口页面
     */
    public function add_porder() {
        $d = array('title' => '电话兑换', 'msg' => '', 'no_load_bootstrap_plugins' => true);
        $this->layout->view('order_manage/add_porder', $d);
    }

    /*
     * 账号密码认证
     */

    public function check_cardauth() {

        $numcode = $this->input->post('numcode');
        $password = $this->input->post('password');
        $result = $this->order_model->check_cardauth($numcode, $password);
        if ($result) {
            if( $result->is_draw != 0 ){
                json_out_put(return_model(0, '验证成功', $result->id));
            }
            json_out_put(return_model(2001, '该卡不能进行兑换！', NULL));
        } else {
            json_out_put(return_model('2001', '卡号或密码错误！', NULL));
        }
    }

    /*
     * 显示该卡对应礼册的礼品列表页面
     */

    public function gift_list() {
        $giftcard_id = $this->input->get('id');
        $d = array('title' => '兑换商品列比表', 'msg' => '', 'no_load_bootstrap_plugins' => true);
        $d['giftcard'] = $this->order_model->get_card_info($giftcard_id);
        //var_dump($d);
        $d['gift'] = $this->order_model->get_gift_list($giftcard_id);
        $d['deliver'] = $this->deliver_model->get_deliver();
        $this->layout->view('order_manage/gift_list', $d);
    }

    /*
     * ajax 显示礼品列表
     */
    public function ajax_gift_list() {
        $d = $this->order_model->gift_page_data($this->data_table_parser);
        $this->load->view('json/datatable', $d);
    }

    /*
     * 保存订单
     */

    public function save_porder() {
        $data = $this->order_model->get_order_params();
        $data['ctime'] = $data['utime'] = date('Y-m-d H:i:s');
        $data['order_source'] = 1;
        $data['status'] = 1;
        if ($insert_id = $this->order_model->add_order($data)) {
            json_out_put(return_model(0, '操作成功', $insert_id));
        } else {
            json_out_put(return_model('2001', '操作失败', NULL));
        }
    }
    
    /**
     * 
     */
    public function update_porder_status(){
        $ids = $this->input->post('ids');
        $data['status'] = $this->input->post('status');
        $data['remark'] = $this->input->post('remark');
        $aff_num = $this->order_model->update_order_info($data,array(),array('id'=>$ids));
        if(is_numeric($aff_num)){
            json_out_put(return_model(0, '修改成功！', $aff_num));
        }else{
            json_out_put(return_model(2001, '修改失败！', NULL));
        }
    }

    /*
     * 兑换订单列表显示
     */

    public function order_list() {
        $d = array('title' => '兑换订单列表', 'msg' => '', 'no_load_bootstrap_plugins' => true);
        $this->layout->view('order_manage/order_list', $d);
    }

    /*
     * ajax加载兑换订单列表
     */

    public function ajax_order_list() {
        $d = $this->order_model->order_page_data($this->data_table_parser);
        $this->load->view('json/datatable', $d);
    }

    /*
     * 实物销售列表页面
     */

    public function eorder_list() {
        $d = array('title' => '实物销售管理', 'msg' => '', 'no_load_bootstrap_plugins' => true);
        $this->layout->view('order_manage/eorder_list', $d);
    }

    /*
     * ajax获取销售列表
     */

    public function ajax_eorder_list() {
        $d = $this->order_model->eorder_page_data($this->data_table_parser);
        //var_dump($d);
        $this->load->view('json/datatable', $d);
    }

    /**
     * 新建实物销售
     */
    public function add_eorder() {
        $d = array('title' => '', 'msg' => '新建实物销售单', 'no_load_bootstrap_plugins' => true);
        $d['sales'] = $this->user_model->get_user();
        $d['customer'] = $this->customer_model->get_customer();
        $d['gift'] = $this->goods_manage_model->get_goods_info(array('status' => 1),array());
        #var_dump($d);
        $this->layout->view('order_manage/add_eorder', $d);
    }

    /**
     * 保存实物销售单
     */
    public function save_eorder() {
        $data = $this->order_model->get_save_eorder_params();
        $gift_book_arr = $this->input->post('gift_book_arr');
        $data['oper_person'] = $this->uc_service->get_user_nickname();
        $data['status'] = 1;
        $data['ctime'] = $data['utime'] = date('Y-m-d H:i:s');
        $order_name = '';
        $price = 0;
        foreach ($gift_book_arr as $tmp) {
            $order_name = $order_name . trim($tmp['gift_book_name']) . '*' . $tmp['book_count'] . ',';
            $price = $price + $tmp['sum_price'];
        }
        $data['order_name'] = rtrim($order_name, ',');
        $data['price'] = $price;
        $insert_id = $this->order_model->save_eorder($data);
        $eorder_book_maps = array();
        foreach ($gift_book_arr as $tmp) {
            $eorder_book_map = array();
            $eorder_book_map['eorder_id'] = $insert_id;
            $eorder_book_map['book_id'] = $tmp['gift_book_id'];
            $eorder_book_map['book_name'] = $tmp['gift_book_name'];
            $eorder_book_map['price'] = $tmp['price'];
            $eorder_book_map['discount'] = $tmp['discount'];
            $eorder_book_map['book_count'] = $tmp['book_count'];
            $eorder_book_map['sum_price'] = $tmp['sum_price'];
            $eorder_book_map['book_remark'] = $tmp['book_remark'];
            $eorder_book_map['status'] = 1;
            $eorder_book_map['ctime'] = date('Y-m-d H:i:s');
            $eorder_book_map['utime'] = date('Y-m-d H:i:s');
            array_push($eorder_book_maps, $eorder_book_map);
        }
        $this->order_model->minsert_eorder_book($eorder_book_maps);
        if ($insert_id) {
            json_out_put(return_model(0, '添加成功', $insert_id));
        } else {
            json_out_put(return_model('3001', '添加失败', NULL));
        }
    }

    /*
     * 编辑实物订单
     */

    public function edit_eorder() {
        $id = $this->input->get('id');
        $d = array('title' => '编辑实物销售单', 'msg' => '', 'no_load_bootstrap_plugins' => true);
        $d['sales'] = $this->user_model->get_user();
        $d['customer'] = $this->customer_model->get_customer();
        #$d['giftbook'] = $this->giftbook_model->get_giftbook_info();
        $d['gift'] = $this->goods_manage_model->get_goods_info(array('status' => 1),array());
        $order = $this->order_model->get_eorder_info(array('id' => $id));
        $eorder = $order[0];
        $init_customer = $this->customer_model->get_customer(array('id' => $eorder['customer_id']))[0];
        $d['init_customer'] = $init_customer;
        $d['book_list'] = $this->order_model->get_eorder_book_list(array('status' => 1, 'eorder_id' => $eorder['id']));
        $d['eorder'] = $eorder;
        //var_dump($d['book_list']);
        $this->layout->view('order_manage/edit_eorder', $d);
    }
    
    /*
     * 打印实物销售单
     */
    
    public function print_eorder(){
        $id = $this->input->get('id');
        $order = $this->order_model->get_eorder_info(array('id' => $id));
        $eorder = $order[0];
        $customer = $this->customer_model->get_customer(array('id' => $eorder['customer_id']))[0];
        $d['book_list'] = $this->order_model->get_eorder_book_list(array('status' => 1, 'eorder_id' => $eorder['id']));       
        $d['eorder'] = $eorder;
        $d['customer'] = $customer;
        //var_dump($d);
        $this->load->view('order_manage/print_eorder', $d);
    }

    /**
     * 编辑保存实物销售单
     */
    public function update_eorder() {
        $data = $this->order_model->get_save_eorder_params();
        $gift_book_arr = $this->input->post('gift_book_arr');
        $eorder_id = $this->input->post('eorder_id');
        $data['oper_person'] = $this->uc_service->get_user_nickname();
        $data['utime'] = date('Y-m-d H:i:s');
        $order_name = '';
        $price = 0;
        foreach ($gift_book_arr as $tmp) {
            $order_name = $order_name . trim($tmp['gift_book_name']) . '*' . $tmp['book_count'] . ',';
            $price = $price + $tmp['sum_price'];
        }
        $data['order_name'] = rtrim($order_name, ',');
        $data['price'] = $price;
        $update_id = $this->order_model->update_eorder($data, array('id' => $eorder_id));

        $eorder_book_maps = array();
        foreach ($gift_book_arr as $tmp) {
            $eorder_book_map = array();
            $eorder_book_map['eorder_id'] = $eorder_id;
            $eorder_book_map['book_id'] = $tmp['gift_book_id'];
            $eorder_book_map['book_name'] = $tmp['gift_book_name'];
            $eorder_book_map['price'] = $tmp['price'];
            $eorder_book_map['discount'] = $tmp['discount'];
            $eorder_book_map['book_count'] = $tmp['book_count'];
            $eorder_book_map['sum_price'] = $tmp['sum_price'];
            $eorder_book_map['book_remark'] = $tmp['book_remark'];
            $eorder_book_map['status'] = 1;
            $eorder_book_map['ctime'] = date('Y-m-d H:i:s');
            $eorder_book_map['utime'] = date('Y-m-d H:i:s');
            array_push($eorder_book_maps, $eorder_book_map);
        }

        $this->order_model->update_eorder_book_list(array('status' => 0), array('eorder_id' => $eorder_id));
        $this->order_model->minsert_eorder_book($eorder_book_maps);
        if ($update_id) {
            json_out_put(return_model(0, '更新成功', $update_id));
        } else {
            json_out_put(return_model('3001', '更新失败', NULL));
        }
    }


    /**
     * 编辑保存实物销售单
     */
    public function update_eorder_status() {
        $ids = $this->input->post('ids');
        $status = $this->input->post('status');
        $pay_remark = $this->input->post('pay_remark');
        $data['oper_person'] = $this->uc_service->get_user_nickname();
        $data['utime'] = date('Y-m-d H:i:s');
        $data['status'] = $status;
        $data['pay_remark'] = $pay_remark;
        $affect_row = $this->order_model->update_eorder_status($data, $ids);
        if (is_numeric($affect_row)) {
            json_out_put(return_model(0, '更新成功', $affect_row));
        } else {
            json_out_put(return_model('2001', '更新失败', NULL));
        }
    }

    /*
     * 退换货管理页面
     */

    public function rorder_list() {
        $d = array('title' => '退换货管理', 'msg' => '', 'no_load_bootstrap_plugins' => true);
        $this->layout->view('order_manage/rorder_list', $d);
    }

    /*
     * ajax 获取退换货列表
     */
    public function ajax_rorder_list(){
        $queryWhere = array();
        if (!isset($_REQUEST['type']) || (isset($_REQUEST['type'])&&$_REQUEST['type'] == '0') ){
            $r_arr = $this->order_model->rorder_page_data($this->data_table_parser);
            $ex_arr = $this->order_model->exorder_page_data($this->data_table_parser);
            $arr = array_merge($r_arr,$ex_arr);
            
        }
        elseif($_REQUEST['type'] =='1'){
            $arr = $this->order_model->rorder_page_data($this->data_table_parser);
        }
        elseif($_REQUEST['type'] =='2'){
            $arr = $this->order_model->exorder_page_data($this->data_table_parser);
        }
        //$arr = $this->order_model->rorder_page_data($this->data_table_parser);
        $d['code'] = 0;
        $d['iTotal'] = count($arr);
        $d['iFilteredTotal'] = $d['iTotal'];
        $d['aaData'] = $arr;
        //var_dump($d);
        $this->load->view('json/datatable', $d);
    }
    

    /**
     * 新增退货
     */
    public function add_return_order() {
        $d = array('title' => '', 'msg' => '退货', 'no_load_bootstrap_plugins' => true);
        //$d['giftbook'] = $this->giftbook_model->get_giftbook_info();
        $this->layout->view('order_manage/add_return_order', $d);
    }

    /**
     * 编辑退货
     */
    public function edit_return_order() {
        $id = $this->input->get('id');
        $d['order_id'] = $id;
        $d['order_info'] = $this->order_model->search_order_info($this->data_table_parser, $id)[0];
        $d['return_info'] = $this->order_model->search_return_info(array('order_id' =>$id))[0];
        //var_dump($d);
        $this->layout->view('order_manage/edit_return_order', $d);
    }
    
    /*
     * 打印退货入库单
     */
    public function print_in_rorder(){
        $id = $this->input->get('id');
        $d['order_id'] = $id;
        $d['order_info'] = $this->order_model->search_order_info($this->data_table_parser, $id)[0];
        $d['return_info'] = $this->order_model->search_return_info(array('order_id' =>$id))[0];
        //var_dump($d);
        $this->load->view('order_manage/print_in_rorder', $d);
    }
    
    public function update_return_order() {
        $order_id = $this->input->post('order_id');
        $data['return_amount'] = $this->input->post('return_amount');
        $data['bank'] = $this->input->post('bank');
        $data['open_bank_address'] = $this->input->post('open_bank_address');
        $data['bank_card_num'] = $this->input->post('bank_card_num');
        $data['bank_card_name'] = $this->input->post('bank_card_name');
        $data['oper_person'] = $this->uc_service->get_user_nickname();;
        $data['remark'] = $this->input->post('remark');
        
        $affect_row = $this->order_model->update_return_order($data, array('order_id' => $order_id));
        if (is_numeric($affect_row)) {
            json_out_put(return_model(0, '修改成功', $affect_row));
        } else {
            json_out_put(return_model('2001', '修改失败', NULL));
        }
    }

    /**
     * 新增换货
     */
    public function add_exchange_order() {
        $d = array('title' => '', 'msg' => '换货', 'no_load_bootstrap_plugins' => true);
        //$d['giftbook'] = $this->giftbook_model->get_giftbook_info();
        $this->layout->view('order_manage/add_exchange_order', $d);
    }

    /*
     * ajax查询订单信息
     */

    public function search_order_info() {
        $id = $this->input->post('order_id');
        $d = $this->order_model->search_order_info($this->data_table_parser, $id);
        //var_dump($d);

        if (count($d) > 0) {
            json_out_put(return_model(0, '搜索成功', $d[0]));
        } else {
            json_out_put(return_model('2001', '搜索失败', NULL));
        }
    }

    /*
     * 保存退货单
     */

    public function save_return_order() {
        $order_id = $this->input->post('order_id');
        $return_amount = $this->input->post('return_amount');
        $bank = $this->input->post('bank');
        $open_bank_address = $this->input->post('open_bank_address');
        $bank_card_num = $this->input->post('bank_card_num');
        $bank_card_name = $this->input->post('bank_card_name');
        $remark = $this->input->post('remark');
        $data['ctime'] = date('Y-m-d H:i:s');
        $data['utime'] = date('Y-m-d H:i:s');
        $data['order_id'] = $order_id;
        $data['return_amount'] = $return_amount;
        $data['bank'] = $bank;
        $data['open_bank_address'] = $open_bank_address;
        $data['bank_card_num'] = $bank_card_num;
        $data['bank_card_name'] = $bank_card_name;
        $data['oper_person'] = $this->uc_service->get_user_nickname();
        $data['remark'] = $remark;

        $insert_id = $this->order_model->save_return_order($data);

        if ($insert_id) {
            json_out_put(return_model(0, '退货成功', $insert_id));
        } else {
            json_out_put(return_model('2001', '退货失败', NULL));
        }
    }

    /**
     * 编辑换货
     */
    public function edit_exchange_order() {
        
        $id = $this->input->get('id');
        $d['order_id'] = $id;
        $d['order_info'] = $this->order_model->search_order_info($this->data_table_parser, $id)[0];
        $book_id = $d['order_info']['book_id'];
        $gift_arr = $this->order_model->search_gifts_by_book($this->data_table_parser, $book_id);
        $d['exchange_info'] = $this->order_model->search_exchange_info(array('order_id' =>$id))[0];
        $d['gift_arr'] = $gift_arr;
        //var_dump($d);
        $this->layout->view('order_manage/edit_exchange_order', $d);
     
    }
    /*
     * 打印换货入库单
     */
    public function print_in_exorder(){
        $id = $this->input->get('id');
        $d['order_id'] = $id;
        $d['order_info'] = $this->order_model->search_order_info($this->data_table_parser, $id)[0];
        $exchange_info = $this->order_model->search_exchange_info(array('order_id' =>$id))[0];
        $gift = $this->goods_manage_model->get_goods_info(array('id'=>$exchange_info['from_gift']),array())[0];
        $d['exchange_info']=$exchange_info;
        $d['gift']=$gift;
        //var_dump($d);
        $this->load->view('order_manage/print_in_exorder', $d);
    }
    
       /*
     * 打印换货出库单
     */
    public function print_out_exorder(){
        $id = $this->input->get('id');
        $d['order_id'] = $id;
        $d['order_info'] = $this->order_model->search_order_info($this->data_table_parser, $id)[0];
        $exchange_info = $this->order_model->search_exchange_info(array('order_id' =>$id))[0];
        $gift = $this->goods_manage_model->get_goods_info(array('id'=>$exchange_info['to_gift']),array())[0];
        $d['exchange_info']=$exchange_info;
        $d['gift']=$gift;
        //var_dump($d);
        $this->load->view('order_manage/print_out_exorder', $d);
    }
    
    public function update_exchange_order() {
        $order_id = $this->input->post('order_id');
        $data['diliver_money'] = $this->input->post('diliver_money');
        $data['remark'] = $this->input->post('remark');
        $data['to_gift'] = $this->input->post('to_gift');
        $data['oper_person'] = $this->uc_service->get_user_nickname();
        $data['utime'] = date('Y-m-d H:i:s');
        
        $affect_row = $this->order_model->update_exchange_order($data, array('order_id' => $order_id));
        if (is_numeric($affect_row)) {
            json_out_put(return_model(0, '修改成功', $affect_row));
        } else {
            json_out_put(return_model('2001', '修改失败', NULL));
        }
    }

    /*
     * 查询订单信息和礼物列表
     */

    public function search_exorder_info() {
        $id = $this->input->post('order_id');
        $d = $this->order_model->search_order_info($this->data_table_parser, $id);

        //var_dump($d);

        if (count($d) > 0) {
            $book_id = $d[0]['book_id'];
            $gift_arr = $this->order_model->search_gifts_by_book($this->data_table_parser, $book_id);
            $data['order_info'] = $d[0];
            $data['gift_arr'] = $gift_arr;
            //var_dump($data);
            json_out_put(return_model(0, '搜索成功', $data));
        } else {
            json_out_put(return_model('2001', '搜索失败', NULL));
        }
    }

    /*
     * 保存换货单
     */

    public function save_exchange_order() {
        $order_id = $this->input->post('order_id');
        $from_gift = $this->input->post('from_gift');
        $to_gift = $this->input->post('to_gift');
        $diliver_money = $this->input->post('diliver_money');
        $remark = $this->input->post('remark');
        $data['order_id'] = $order_id;
        $data['from_gift'] = $from_gift;
        $data['to_gift'] = $to_gift;
        $data['diliver_money'] = $diliver_money;
        $data['remark'] = $remark;
        $data['ctime'] = date('Y-m-d H:i:s');
        $data['utime'] = date('Y-m-d H:i:s');
        $data['oper_person'] = $this->uc_service->get_user_nickname();

        $insert_id = $this->order_model->save_exchange_order($data);

        if ($insert_id) {
            json_out_put(return_model(0, '换货成功', $insert_id));
        } else {
            json_out_put(return_model('2001', '换货失败', NULL));
        }
    }


    /**
     * 加载编辑视图
     */
    public function edit_order() {
        $id = $this->input->get('id');
        $d = array('title' => '编辑客户', 'msg' => '', 'no_load_bootstrap_plugins' => true);
        $d['order'] = $this->order_model->get_order_info(array('id' => $id));
        $d['order']['id'] = $id;
        $d['giftcard'] = $this->order_model->get_card_info($d['order']['card_id']);
        $d['gift'] = $this->order_model->get_gift_list($d['order']['card_id']);
        $d['deliver'] = $this->deliver_model->get_deliver();
        $this->layout->view('order_manage/edit_order', $d);
    }
    
    /**
     * 打印出库订单
     */
    public function print_out_order(){
        $id = $this->input->get('id');
        $d['order'] = $this->order_model->get_order_info(array('id' => $id));
        $d['gift'] = $this->order_model->get_gift_info(array('id'=>$d['order']['gift_id']));
        $this->load->view('order_manage/print_order', $d);
    }
    
    /**
     * 更新请求
     */
    public function do_edit_order(){
        $id = $this->input->post('orderid');
        $updata = $this->order_model->get_editorder_params();
        $aff_row = $this->order_model->update_order_info($updata,array('id'=>$id));
        if (is_numeric($aff_row)) {
            json_out_put(return_model(0, '更新成功', $aff_row));
        } else {
            json_out_put(return_model('2001', '更新失败', NULL));
        }
    }

    /**
     * 模版列表分页
     */
    public function order_list_page() {
        $d = $this->order_model->order_page_data($this->data_table_parser);
        $this->load->view('json/datatable', $d);
    }

    /**
     * 编辑客户
     */
    public function update_order_info() {
        $order_id = $this->input->post('id');
        $data = $this->order_model->get_order_params();
        if ($data['type'] == order_manage_model::MULTIPLE_GOODS_TYPE) {
            if ($check_info = $this->order_model->check_order_num($data['groupid'], 1)) {
                json_out_put(return_model('2002', $check_info, NULL));
            }
        }
        $affect_row = $this->order_model->update_order_info($data, array('id' => $order_id));
        if (is_numeric($affect_row)) {
            json_out_put(return_model(0, '更新成功', $affect_row));
        } else {
            json_out_put(return_model('2001', '更新失败', NULL));
        }
    }

}
