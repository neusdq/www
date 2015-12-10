<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of media_manage
 * 多媒体管理
 * @author pbchen
 */
class media_manage extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('media_model');
        $this->load->library('Data_table_parser');
        $this->data_table_parser->set_db($this->db);
        $this->load->library('uc_service', array('cfg' => $this->config->item('alw_uc')));
    }

    /**
     * 添加media
     */
    public function add_media() {
        //no_load_bootstrap_plugins 
        //不加载 bootstrap.plugins.min.js 加载后影响图片上传插件 
        //默认是加载的

        if ($_POST) {
            $data = $this->media_model->get_media_params();
            $data['ctime'] = $data['utime'] = date('Y-m-d H:i:s');
            $data['status'] = 1;
            //$data['expire_date']=date('Y-m-d');
            if ($insert_id = $this->media_model->add_media($data)) {
                json_out_put(return_model(0, '添加成功', $insert_id));
            } else {
                json_out_put(return_model('2001', '添加失败', NULL));
            }
        } else {
            $d = array('title' => '多媒体管理', 'msg' => '', 'no_load_bootstrap_plugins' => true);
//            $d['brand'] = $this->brand_model->get_brand();
//            $d['classify'] = $this->classify_model->get_classify();
//            $d['suppley'] = $this->supply_model->get_supply();
//            $d['deliver'] = $this->deliver_model->get_deliver();
            $this->layout->view('media_manage/add_media', $d);
        }
    }
    /**
     * 加载编辑视图
     */
    public function edit_media(){
        $id = $this->input->get('id');
        $d = array('title' => '编辑客户', 'msg' => '', 'no_load_bootstrap_plugins' => true);
        $media = $this->media_model->get_media_info(array('id'=>$id));
        $d['media'] = $media[0];
        $this->layout->view('media_manage/edit_media', $d);
    }

    /**
     * 客户列表
     */
    public function media_list() {
        $d = array('title' => '兑换网站列表', 'msg' => '');
        $this->layout->view('media_manage/media_list', $d);
    }

    /**
     * 模版列表分页
     */
    public function media_list_page() {
        $d = $this->media_model->media_page_data($this->data_table_parser);
        $this->load->view('json/datatable', $d);
    }
    
    /**
     * 编辑客户
     */
    public function update_media_info(){
        $media_id = $this->input->post('id');
        $data = $this->media_model->get_media_params();
        if ($data['type'] == media_manage_model::MULTIPLE_GOODS_TYPE) {
            if ($check_info = $this->media_model->check_media_num($data['groupid'], 1)) {
                json_out_put(return_model('2002', $check_info, NULL));
            }
        }
        $affect_row = $this->media_model->update_media_info($data,array('id'=>$media_id));
        if (is_numeric($affect_row)) {
            json_out_put(return_model(0, '更新成功', $affect_row));
        } else {
            json_out_put(return_model('2001', '更新失败', NULL));
        }
    }
    
}




