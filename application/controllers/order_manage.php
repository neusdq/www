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
        $this->load->model('user_model');
        $this->load->model('customer_model');
        $this->load->model('giftbook_model');
        $this->load->model('order_model');
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
            json_out_put(return_model(0, '验证成功', $numcode));
        } else {
            json_out_put(return_model('2001', '验证失败', NULL));
        }
    }

    /*
     * 显示该卡对应礼册的礼品列表页面
     */

    public function gift_list() {
        $num_code = $this->input->get('num_code');
        $d = array('title' => '兑换商品列比表', 'msg' => '', 'no_load_bootstrap_plugins' => true);
        $data = $this->order_model->get_card_info($num_code);
        $this->layout->view('order_manage/gift_list', $data);
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
        $d['giftbook'] = $this->giftbook_model->get_giftbook_info();
        $this->layout->view('order_manage/add_eorder', $d);
    }

    /**
     * 保存实物销售单
     */
    public function save_eorder() {
        $data = $this->order_model->get_save_eorder_params();
        $gift_book_arr = $this->input->post('gift_book_arr');
        $data['oper_person'] = $this->uc_service->get_user_nickname();
        $data['status'] =1;
        $data['ctime'] = $data['utime'] = date('Y-m-d H:i:s');
        $order_name = '';
        $price = 0;
        foreach ($gift_book_arr as $tmp) {         
            $order_name=$order_name.trim($tmp['gift_book_name']).'*'.$tmp['book_count'].',';
            $price =$price+ $tmp['sum_price'];
            
        }
        $data['order_name'] = rtrim($order_name,',');
        $data['price'] = $price;
        $insert_id = $this->order_model->save_eorder($data);
        $eorder_book_maps = array();
        foreach ($gift_book_arr as $tmp) {
            $eorder_book_map= array();
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
            array_push($eorder_book_maps,$eorder_book_map);     
        }
        $this->order_model->minsert_eorder_book($eorder_book_maps);
        if ($insert_id) {
            json_out_put(return_model(0, '添加成功', $insert_id));
        } else {
            json_out_put(return_model('3001', '添加失败', NULL));
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
     * 后面保留
     */

    /**
     * 加载编辑视图
     */
    public function edit_order() {
        $id = $this->input->get('id');
        $d = array('title' => '编辑客户', 'msg' => '', 'no_load_bootstrap_plugins' => true);
        $order = $this->order_model->get_order_info(array('id' => $id));
        $d['order'] = $order[0];
        $this->layout->view('order_manage/edit_order', $d);
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
