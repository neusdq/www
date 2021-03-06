<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of customer_manage
 * 客户管理
 */
class customer_manage extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('customer_model');
        $this->load->library('Data_table_parser');
        $this->data_table_parser->set_db($this->db);
        $this->load->library('uc_service', array('cfg' => $this->config->item('alw_uc')));
    }

    /**
     * 添加客户
     */
    public function add_customer() {
        if ($_POST) {
            $data = $this->customer_model->get_customer_params();
            $data['ctime'] = $data['utime'] = date('Y-m-d H:i:s');
            $data['status'] = 1;
            if ($insert_id = $this->customer_model->add_customer($data)) {
                json_out_put(return_model(0, '添加成功', $insert_id));
            } else {
                json_out_put(return_model('2001', '添加失败', NULL));
            }
        } else {
            $d = array('title' => '客户管理', 'msg' => '', 'no_load_bootstrap_plugins' => true);
            $this->layout->view('customer_manage/add_customer', $d);
        }
    }

    /**
     * 加载编辑视图
     */
    public function edit_customer() {
        $id = $this->input->get('id');
        $d = array('title' => '编辑客户', 'msg' => '', 'no_load_bootstrap_plugins' => true);
        $customer = $this->customer_model->get_customer(array('id' => $id))[0];
        $d['customer']=$customer;
        $this->layout->view('customer_manage/edit_customer', $d);
    }

    /**
     * 客户列表
     */
    public function customer_list() {
        $d = array('title' => '客户列表', 'msg' => '');
        $this->layout->view('customer_manage/customer_list', $d);
    }

    /**
     * 客户列表分页
     */
    public function customer_list_page() {
        $d = $this->customer_model->customer_page_data($this->data_table_parser);
        $this->load->view('json/datatable', $d);
    }

    /**
     * 编辑客户
     */
    public function update_customer_info() {
        $customer_id = $this->input->post('id');
        $data['name'] = $this->input->post('name');
        $data['contact_person'] = $this->input->post('contact_person');
        $data['type'] = $this->input->post('type');
        $data['phone'] = $this->input->post('phone');
        $data['postcode'] = $this->input->post('postcode');
        $data['email'] = $this->input->post('email');
        $data['address'] = $this->input->post('address');
        $data['remark'] = $this->input->post('remark');
        
        $affect_row = $this->customer_model->update_customer_info($data, array('id' => $customer_id));
        if (is_numeric($affect_row)) {
            json_out_put(return_model(0, '更新成功', $affect_row));
        } else {
            json_out_put(return_model('2001', '更新失败', NULL));
        }
    }
    /**
     * 更改状态
     */
    public function update_status() {
        $ids = $this->input->post('ids');
        $status = $this->input->post('status');
        $data['status'] = $status;
        $affect_row = $this->customer_model->update_status($data, $ids);
        if (is_numeric($affect_row)) {
            json_out_put(return_model(0, '更新成功', $affect_row));
        } else {
            json_out_put(return_model('2001', '更新失败', NULL));
        }
         
         
    }
}
