<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of order_manage
 * 多媒体管理
 * @author pbchen
 */
class order_manage extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('order_model');
        $this->load->library('Data_table_parser');
        $this->data_table_parser->set_db($this->db);
        $this->load->library('uc_service', array('cfg' => $this->config->item('alw_uc')));
    }

    /**
     * 添加order
     */
    public function add_porder() {
        //no_load_bootstrap_plugins 
        //不加载 bootstrap.plugins.min.js 加载后影响图片上传插件 
        //默认是加载的

        if ($_POST) {
            $data = $this->order_model->get_order_params();
            $data['ctime'] = $data['utime'] = date('Y-m-d H:i:s');
            $data['status'] = 1;
            var_dump($data);

            /*
              //$data['expire_date']=date('Y-m-d');
              if ($insert_id = $this->order_model->add_orderinfo($data)) {
              json_out_put(return_model(0, '添加成功', $insert_id));
              } else {
              json_out_put(return_model('2001', '添加失败', NULL));
              }
             * /
             */
        } else {
            $d = array('title' => '电话兑换', 'msg' => '', 'no_load_bootstrap_plugins' => true);
//            $d['brand'] = $this->brand_model->get_brand();
//            $d['classify'] = $this->classify_model->get_classify();
//            $d['suppley'] = $this->supply_model->get_supply();
//            $d['deliver'] = $this->deliver_model->get_deliver();
            $this->layout->view('order_manage/add_porder', $d);
        }
    }

    public function check_cardauth() {
        //no_load_bootstrap_plugins 
        //不加载 bootstrap.plugins.min.js 加载后影响图片上传插件 
        //默认是加载的

        if ($_POST) {
            $numcode = $this->input->post('numcode');
            $password = $this->input->post('password');
            $result = $this->order_model->check_cardauth($numcode, $password);
            if ($result) {
                json_out_put(return_model(0, '验证成功', $numcode));
            } else {
                json_out_put(return_model('2001', '验证失败', NULL));
            }
        }
    }

    public function gift_list() {
        //no_load_bootstrap_plugins 
        //不加载 bootstrap.plugins.min.js 加载后影响图片上传插件 
        //默认是加载的

        if ($_POST) {
            $d = $this->order_model->gift_page_data($this->data_table_parser);
            $this->load->view('json/datatable', $d);
        } else {
            $num_code = $this->input->get('num_code');
            $d = array('title' => '兑换商品列比表', 'msg' => '', 'no_load_bootstrap_plugins' => true);
            $data = $this->order_model->get_card_info($num_code);
            $this->layout->view('order_manage/gift_list', $data);
        }
    }

    public function ajax_gift_list() {

        $d = $this->order_model->gift_page_data($this->data_table_parser);
        $this->load->view('json/datatable', $d);
    }

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
    
    public function order_list() {
            $d = array('title' => '兑换订单列表', 'msg' => '', 'no_load_bootstrap_plugins' => true);
            $this->layout->view('order_manage/order_list', $d);
    }
    public function ajax_order_list() {
        
        $d = $this->order_model->order_page_data($this->data_table_parser);
        //var_dump($d);
        $this->load->view('json/datatable', $d);
    }
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
