<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of theme
 *
 * @author pbchen
 */
class theme extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('theme_model');
        $this->load->library('Data_table_parser');
        $this->data_table_parser->set_db($this->db);
        $this->load->library('uc_service', array('cfg' => $this->config->item('alw_uc')));
    }
    
    /**
     * 添加商品品牌
     */
    public function add_theme(){
        $d['status'] = 1;
        $d['name'] = $this->input->post('name');
        $d['remark'] = $this->input->post('remark');
        if($id=$this->theme_model->add_theme($d)){
            json_out_put(return_model(0, '添加成功', $id));
        }else{
            json_out_put(return_model('2011', '添加失败', NULL));
        }
    }
    
    /**
     * 编辑品牌
     */
    public function edit_theme(){
        $d['status'] = $this->input->post('status');
        $d['name'] = $this->input->post('name');
        $d['remark'] = $this->input->post('remark');
        $id = $this->input->post('id');
        if($check_info=$this->theme_model->check_theme_update(array($id),$d['status'])){
            json_out_put(return_model('2022', $check_info, NULL));
        }
        $affect_row = $this->theme_model->update_theme_info($d,array('id'=>$id));
        if (is_numeric($affect_row)) {
            json_out_put(return_model(0, '更新成功', $affect_row));
        } else {
            json_out_put(return_model('2022', '更新失败', NULL));
        }
    }
    
    /**
     * 更新启用&停用
     */
    public function update_theme(){
        $ids = $this->input->post('ids');
        $d['status'] = $this->input->post('status');
        if($check_info=$this->theme_model->check_theme_update($ids,$d['status'])){
            json_out_put(return_model('2022', $check_info, NULL));
        }
        $this->db->where_in('id',$ids);
        $aff_row = $this->theme_model->update_theme_info($d);
        json_out_put(return_model(0, '添加成功', $aff_row));
    }
    
    /**
     * 品牌分页
     */
    public function theme_list_page(){
        $d = $this->theme_model->theme_page_data($this->data_table_parser);
        $this->load->view('json/datatable', $d);
    }
    
    
}
