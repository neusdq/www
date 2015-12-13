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
        if ($_POST) {
            $data = $this->media_model->get_media_params();
            $data['ctime'] = $data['utime'] = date('Y-m-d H:i:s');
            $data['status'] = 1;
            if ($insert_id = $this->media_model->add_mediainfo($data)) {
                json_out_put(return_model(0, '添加成功', $insert_id));
            } else {
                json_out_put(return_model('2001', '添加失败', NULL));
            }
        } else {
            $d = array('title' => '多媒体管理', 'msg' => '', 'no_load_bootstrap_plugins' => true);
            $this->layout->view('media_manage/add_media', $d);
        }
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
        //vardump($d);
        $this->load->view('json/datatable', $d);
    }
    
    public function edit_media() {
        $id = $this->input->get('id');
        $d = array('title' => '编辑多媒体', 'msg' => '', 'no_load_bootstrap_plugins' => true);
        $d['media']=$this->media_model->get_mediainfo(array('id' => $id))[0];
        $this->layout->view('media_manage/edit_media', $d);
    }
    
    public function update_media_info() {
        $media_id = $this->input->post('id');
        $data['name'] = $this->input->post('name');
        $data['type'] = $this->input->post('type');
        $data['author'] = $this->input->post('author');
        $data['expire_date'] = $this->input->post('expire_date');
        $data['remark'] = $this->input->post('remark');
        $pic_ids = $this->input->post('pic_ids');
        if(!empty($pic_ids)){           
            $data['media_id']=explode(',',$pic_ids)[0];
        }
        
        $affect_row = $this->media_model->update_media_info($data, array('id' => $media_id));
        if (is_numeric($affect_row)) {
            json_out_put(return_model(0, '修改成功', $affect_row));
        } else {
            json_out_put(return_model('2001', '修改失败', NULL));
        }
    }
    
    public function update_status() {
        $ids = $this->input->post('ids');
        $status = $this->input->post('status');
        $data['status'] = $status;
        $affect_row = $this->media_model->update_status($data, $ids);
        if (is_numeric($affect_row)) {
            json_out_put(return_model(0, '更新成功', $affect_row));
        } else {
            json_out_put(return_model('2001', '更新失败', NULL));
        }        
    }
    
    
    
}




