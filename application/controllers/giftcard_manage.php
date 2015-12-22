<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of giftcard_manage
 *
 * @author pbchen
 */
class giftcard_manage extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('giftcard_model');
        $this->load->model('customer_model');
        $this->load->model('wechat_model');
        $this->load->model('giftbook_model');
        $this->load->library('Data_table_parser');
        $this->data_table_parser->set_db($this->db);
        $this->load->library('uc_service', array('cfg' => $this->config->item('alw_uc')));
    }
    
    /**
     * 礼品卡下单
     */
    public function giftcard_order() {
        if ($_POST) {
            $data = $this->giftcard_model->get_giftcard_order_params();
            if ($insert_id = $this->giftcard_model->add_giftcard_order($data)) {
                json_out_put(return_model(0, '添加成功', $insert_id));
            } else {
                json_out_put(return_model('3001', '添加失败', NULL));
            }
        } else {
            $d = array('title' => '礼品卡管理', 'msg' => '', 'no_load_bootstrap_plugins' => true);
            $d['sales'] = $this->user_model->get_user();
            $d['customer'] = $this->customer_model->get_customer();
            $d['wechat'] = $this->wechat_model->get_wechat();
            $d['giftbook'] = $this->giftbook_model->get_giftbook_info();
            $this->layout->view('giftcard_manage/giftcard_order', $d);
        }
    }
    
    /**
     * 礼品卡编辑
     */
    public function edit_giftcard_order(){
        $id = $this->input->post('id');
        $d['sales_id'] = $this->input->post('sales');
        $d['custom_id'] = $this->input->post('customer');
        $d['end_user'] = $this->input->post('enduser');
        $d['wechat_id'] = $this->input->post('wechat');
        $d['remark'] = $this->input->post('remark');
        $affect_row = $this->giftcard_model->update_giftcard_order_info($d,array('id'=>$id));
        if (is_numeric($affect_row)) {
            json_out_put(return_model(0, '更新成功', $affect_row));
        } else {
            json_out_put(return_model('3001', '更新失败', NULL));
        }
    }
    
    /**
     * 加载编辑视图
     */
    public function edit_giftcard(){
        $id = $this->input->get('id');
        $d = array('title' => '编辑礼册', 'msg' => '', 'no_load_bootstrap_plugins' => true);
        $giftcard = $this->giftcard_model->get_giftcard_info(array('id'=>$id));
        $d['giftcard'] = $giftcard[0];
        $this->layout->view('giftcard_manage/edit_giftcard', $d);
    }
    
    /**
     * 礼册列表
     */
    public function giftcard_order_list() {
        $d = array('title' => '礼品卡管理', 'msg' => '');
        $d['sales'] = $this->user_model->get_user();
        $d['customer'] = $this->customer_model->get_customer();
        $d['wechat'] = $this->wechat_model->get_wechat();
        $this->layout->view('giftcard_manage/giftcard_order_list', $d);
    }
    
    /**
     * 礼册列表分页
     */
    public function giftcard_order_list_page() {
        $d = $this->giftcard_model->giftcard_order_list_page_data($this->data_table_parser);
        $this->load->view('json/datatable', $d);
    }
    
    /**
     * 打印销售单
     */
    public function print_sales_order(){
        $id = $this->input->get('id');
        $order = $this->giftcard_model->sales_order_info(array('card_order.id'=>$id));
        $d['order'] = $order[0];
        $d['book'] = $this->giftcard_model->get_order_book(array('order_id'=>$id));
        $this->load->view('giftcard_manage/sales_order', $d);
    }
    
    /**
     * 退卡打印
     */
    public function print_cancel_order(){
        $id = $this->input->get('id');
        $d['book'] = $this->giftcard_model->get_cancel_order_book($id);
        $d['order'] = array();
        if($d['book']){
            $order = $this->giftcard_model->sales_order_info(array('card_order.id'=>$d['book'][0]['order_id']));
            $d['order'] = $order[0];
        }
        $this->load->view('giftcard_manage/cancel_order', $d);
    }
    
    /**
     * 修改开卡付款状态
     */
    public function update_paystatus(){
        $ids = $this->input->post('ids');
        $d['pay_status'] = $this->input->post('paystatus');
        $d['pay_remark'] = $this->input->post('pay_remark');
        $affect_row = $this->giftcard_model->update_giftcard_order_info($d,array(),array('id'=>$ids));
        if (is_numeric($affect_row)) {
            json_out_put(return_model(0, '更新成功', $affect_row));
        } else {
            json_out_put(return_model('3001', '更新失败', NULL));
        }
    }
    
    /**
     * 更新停用&启用
     */
    public function update_giftcard(){
        $ids = $this->input->post('ids');
        $d['status'] = $this->input->post('status');
        if($remark=$this->input->post('remark')){
            $d['remark'] = $remark;
        }
        $this->db->where_in('id',$ids);
        $aff_row = $this->giftcard_model->update_giftcard_info($d);
        json_out_put(return_model(0, '添加成功', $aff_row));
    }
    
    /**
     * 礼品卡库列表视图
     */
    public function giftcard_inventory(){
        $d = array('title' => '礼品卡库', 'msg' => '');
        $this->layout->view('giftcard_manage/giftcard_inventory', $d);
    }
    
    /**
     * 礼品卡库列表数据
     */
    public function giftcard_inventory_page(){
        $d = $this->giftcard_model->giftcard_inventory_page_data($this->data_table_parser);
        $this->load->view('json/datatable', $d);
    }
    
    /**
     * 退卡列表
     */
    public function cancel_giftcard(){
        $d = array('title' => '退卡列表', 'msg' => '');
        $d['sales'] = $this->user_model->get_user();
        $d['customer'] = $this->customer_model->get_customer();
        $this->layout->view('giftcard_manage/giftcard_cancel_list', $d);
    }
    
    /**
     * 退卡
     */
    public function cancel_giftcard_page(){
        $d = $this->giftcard_model->cancel_giftcard_page_data($this->data_table_parser);
        $this->load->view('json/datatable', $d);
    }
    
    /**
     * 下载
     */
    public function download_giftcard(){
        $data = $this->giftcard_model->download_giftcard_data();
        $header = array('卡号','密码','状态','生成时间');
        download_model($header, $data);
    }
    
    /**
     * 生产礼卡
     */
    public function create_giftcard(){
        $d['scode'] = $this->input->post('scode');
        $d['ecode'] = $this->input->post('ecode');
        $aff_row = $this->giftcard_model->create_giftcard($d);
        if(intval($aff_row)>0){
            json_out_put(return_model(0, '添加成功', $aff_row));
        }else{
            json_out_put(return_model(3001, '生成失败', NULL));
        }
    }
    
    /**
     * 退卡
     */
    public function do_cancel_giftcard(){
        
        if($_POST){
            $data = $this->giftcard_model->cancel_giftcard_params();
            $data['modify_user'] = $this->uc_service->get_user_id();
            if ($insert_id = $this->giftcard_model->add_cancel_giftcard($data)) {
                json_out_put(return_model(0, '添加成功', $insert_id));
            } else {
                json_out_put(return_model('3001', '添加失败', NULL));
            }
        }else{
            $d = array('title' => '退卡列表', 'msg' => '');
            $d['sales'] = $this->user_model->get_user();
            $d['customer'] = $this->customer_model->get_customer();
            $this->layout->view('giftcard_manage/giftcard_cancel', $d);
        }
    }
    
    /**
     * 修改退卡信息
     */
    public function edit_cancel_giftcard(){
        $id = $this->input->post('id');
        $d['sales_id'] = $this->input->post('sales');
        $d['custom_id'] = $this->input->post('customer');
        $d['end_user'] = $this->input->post('enduser');
        $d['remark'] = $this->input->post('remark');
        $d['modify_user'] = $this->uc_service->get_user_id();
        $aff_row = $this->giftcard_model->update_cancel_giftcard($d,array('id'=>$id));
        if(is_numeric($aff_row)){
            json_out_put(return_model(0, '修改成功！', $aff_row));
        }else{
            json_out_put(return_model(3001, '修改失败！', NULL));
        }
    }
    
    /**
     * 打印退卡信息
     */
    public function print_cancel_info(){
        $id = $this->input->get('id');
        $this->load->view('giftcard_manage/print_cancel', $d);
    }
    
    /**
     * 打印开卡信息
     */
    public function print_giftcard_order(){
        $id = $this->input->get('id');
        $this->load->view('giftcard_manage/print_giftcard_order', $d);
    }
    
}
