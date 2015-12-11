<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of website_manage
 * 客户管理
 * @author pbchen
 */
class website_manage extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('website_model');
        $this->load->library('Data_table_parser');
        $this->data_table_parser->set_db($this->db);
        $this->load->library('uc_service', array('cfg' => $this->config->item('alw_uc')));
    }

    /**
     * 添加website
     */
    public function add_website() {
        //no_load_bootstrap_plugins 
        //不加载 bootstrap.plugins.min.js 加载后影响图片上传插件 
        //默认是加载的

        if ($_POST) {
            $data = $this->website_model->get_website_params();
            $data['ctime'] = $data['utime'] = date('Y-m-d H:i:s');
            $data['status'] = 1;
            //$data['expire_date']=date('Y-m-d');
            if ($insert_id = $this->website_model->add_website($data)) {
                json_out_put(return_model(0, '添加成功', $insert_id));
            } else {
                json_out_put(return_model('2001', '添加失败', NULL));
            }
        } else {
            $d = array('title' => '兑换网站管理', 'msg' => '', 'no_load_bootstrap_plugins' => true);
//            $d['brand'] = $this->brand_model->get_brand();
//            $d['classify'] = $this->classify_model->get_classify();
//            $d['suppley'] = $this->supply_model->get_supply();
//            $d['deliver'] = $this->deliver_model->get_deliver();
            $this->layout->view('website_manage/add_website', $d);
        }
    }
    /**
     * 加载编辑视图
     */
    public function edit_website(){
        $id = $this->input->get('id');
        $d = array('title' => '编辑客户', 'msg' => '', 'no_load_bootstrap_plugins' => true);
        $website = $this->website_model->get_website_info(array('id'=>$id));
        $d['website'] = $website[0];
        $this->layout->view('website_manage/edit_website', $d);
    }

    /**
     * 客户列表
     */
    public function website_list() {
        $d = array('title' => '兑换网站列表', 'msg' => '');
        $this->layout->view('website_manage/website_list', $d);
    }

    /**
     * 客户列表分页
     */
    public function website_list_page() {
        $d = $this->website_model->website_page_data($this->data_table_parser);
        var_dump($d);
        exit();
        //$this->load->view('json/datatable', $d);
    }
    
    /**
     * 编辑客户
     */
    public function update_website_info(){
        $website_id = $this->input->post('id');
        $data = $this->website_model->get_website_params();
        if ($data['type'] == website_manage_model::MULTIPLE_GOODS_TYPE) {
            if ($check_info = $this->website_model->check_website_num($data['groupid'], 1)) {
                json_out_put(return_model('2002', $check_info, NULL));
            }
        }
        $affect_row = $this->website_model->update_website_info($data,array('id'=>$website_id));
        if (is_numeric($affect_row)) {
            json_out_put(return_model(0, '更新成功', $affect_row));
        } else {
            json_out_put(return_model('2001', '更新失败', NULL));
        }
    }
    
}


