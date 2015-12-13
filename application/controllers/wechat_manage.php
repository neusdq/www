<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of wechat_manage
 */
class wechat_manage extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('wechat_model');
        $this->load->library('Data_table_parser');
        $this->data_table_parser->set_db($this->db);
        $this->load->library('uc_service', array('cfg' => $this->config->item('alw_uc')));
    }

    /**
     * 添加wechat
     */
    public function add_wechat() {
        if ($_POST) {
            $data = $this->wechat_model->get_wechat_params();
            $data['ctime'] = $data['utime'] = date('Y-m-d H:i:s');
            $data['status'] = 1;
            if ($insert_id = $this->wechat_model->add_wechat($data)) {
                json_out_put(return_model(0, '添加成功', $insert_id));
            } else {
                json_out_put(return_model('2001', '添加失败', NULL));
            }
        } else {
            $d = array('title' => '微信模版管理', 'msg' => '', 'no_load_bootstrap_plugins' => true);
            $this->layout->view('wechat_manage/add_wechat', $d);
        }
    }

    /**
     * 加载编辑视图
     */
    public function edit_wechat() {
        $id = $this->input->get('id');
        $d = array('title' => '编辑微信模版', 'msg' => '', 'no_load_bootstrap_plugins' => true);
        $d['wechat']=$this->wechat_model->get_wechat(array('id' => $id))[0];
        $this->layout->view('wechat_manage/edit_wechat', $d);
    }

    /**
     * 客户列表
     */
    public function wechat_list() {
        $d = array('title' => '兑换网站列表', 'msg' => '');
        $this->layout->view('wechat_manage/wechat_list', $d);
    }

    /**
     * 模版列表分页
     */
    public function wechat_list_page() {
        $d = $this->wechat_model->wechat_page_data($this->data_table_parser);
        $this->load->view('json/datatable', $d);
    }

    /**
     * 编辑微信
     */
    public function update_wechat_info() {
        $wechat_id = $this->input->post('id');
        $data['name'] = $this->input->post('name');
        $data['style'] = $this->input->post('style');
        $data['vedio_id'] = $this->input->post('vedio_id');
        $data['pic_id'] = $this->input->post('pic_id');
        $data['audio_id'] = $this->input->post('audio_id');
        $data['sender'] = $this->input->post('sender');
        $data['reciver'] = $this->input->post('reciver');
        $data['copywriter'] = $this->input->post('copywriter');
        $data['remark'] = $this->input->post('remark');      
        $affect_row = $this->wechat_model->update_wechat_info($data, array('id' => $wechat_id));
        if (is_numeric($affect_row)) {
            json_out_put(return_model(0, '修改成功', $affect_row));
        } else {
            json_out_put(return_model('2001', '修改失败', NULL));
        }
    }
    /*
     * 更新状态
     */
      public function update_status() {
        $ids = $this->input->post('ids');
        $status = $this->input->post('status');
        $data['status'] = $status;
        $affect_row = $this->wechat_model->update_status($data, $ids);
        if (is_numeric($affect_row)) {
            json_out_put(return_model(0, '更新成功', $affect_row));
        } else {
            json_out_put(return_model('2001', '更新失败', NULL));
        }
         
         
    }

}
