<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of media_model
 *
 * @author pbchen
 */
class media_model extends CI_Model {
    
    private $_mediainfo_tb = '`gift_management`.`mediainfo`';
    private $_media_tb = '`gift_management`.`media`';
    const MEDIA_START_STATUS = 1;
    const MEDIA_STOP_STATUS = 2;
    private $_media_status = array(
        '1' => '启用',
        '2' => '停用'
    );
    private $_media_type = array(
        '1' => '图片',
        '2' => '音频',
        '3' => '视频'
    );
    
    function __construct() {
        parent::__construct();
    }
    

    public function get_media_params() {
        $data['name'] = $this->input->post('name');
        $data['type'] = $this->input->post('type');
        $data['author'] = $this->input->post('author');
        $data['expire_date'] = $this->input->post('expire_date');
        $data['remark'] = $this->input->post('remark');
        $data['media_id'] = $this->input->post('pic_ids');
        return $data;
    }
    
    /**
     * 添加媒体资源
     * @param type $media_info
     * @return type
     */
    public function add_media($media_info){
        $media_info['ctime'] = $media_info['utime'] = date('Y-m-d H:i:s');
        $media_info['status'] = 1;
        $this->db->insert($this->_media_tb, $media_info);
        return $this->db->insert_id();
    }
    
    public function add_mediainfo($media_info){
        $media_info['ctime'] = $media_info['utime'] = date('Y-m-d H:i:s');
        $media_info['status'] = 1;
        $this->db->insert($this->_mediainfo_tb,$media_info);
        return $this->db->insert_id();
    }
    
    /**
     * 获取上传资源信息
     * @param type $where
     * @param type $where_in
     * @return type
     */
    public function get_media($where=array(),$where_in=array()){
        $this->db->select('*')->from($this->_media_tb);
        if($where){
            $this->db->where($where);
        }
        if($where_in){
            foreach($where_in as $k=>$v){
                $this->db->where_in($k,$v);
            }
        }
        return $this->db->get()->result_array();
    }
    
    public function media_page_data($dtparser){
        $cols = array('`mediainfo`.`id`','`mediainfo`.`name`','`mediainfo`.`type`','`mediainfo`.`status`'
            ,'`mediainfo`.`author`','`mediainfo`.`remark`','`mediainfo`.`expire_date`');
        $sort_cols = array('4'=>'`mediainfo`.`status`');
        $filter_cols = array();
        //查询主表
        $dtparser->select($cols, $sort_cols, $filter_cols, FALSE);
        $dtparser->from($this->_mediainfo_tb);
        //条件
        $cwhere = $this->get_mediainfo_page_where();
        $d['code'] = 0;
        $d['iTotal'] = 0;
        $d['iFilteredTotal'] = 0;
        $d['aaData'] = array();
        if( $d['code'] == 0 ){
            $d['iTotal'] = $dtparser->count($cwhere);
            $d['iFilteredTotal'] = $d['iTotal'];
            $query = $dtparser->get($cwhere);
            $arr = $query->result_array();
            $this->ajax_list_table_data($arr);
            $d['aaData']=$arr;
        }
        return $d;
        
        
    }
    
    public function ajax_list_table_data(&$pageData){
        foreach($pageData as &$v){
            $v['checkbox'] = "<input name='row_sel' type='checkbox' id='{$v['id']}'>";
            $v['oper'] = "<a rel='{$v['id']}'class='edit oper' href='/media_manage/edit_media?id={$v['id']}'>编辑</a>";
            //$v['oper'] .= "<a rel='{$v['id']}'class='load oper'>&nbsp;&nbsp;&nbsp;导入</a>";
            $v['status'] = isset($this->_media_status[$v['status']])?$this->_media_status[$v['status']]:'';
            $v['type'] = isset($this->_media_type[$v['type']])?$this->_media_type[$v['type']]:'';
        }
    }
    
    public function get_mediainfo_page_where(){
        $cwhere = array();
        if (isset($_REQUEST['id']) && $_REQUEST['id']!=0) {
            $cwhere['`mediainfo`.`id`'] = $_REQUEST['id'];
        }
        if (isset($_REQUEST['name']) && $_REQUEST['name'] != '') {
            $cwhere['`mediainfo`.`name` LIKE '] = '%'.$_REQUEST['name'].'%';
        }
        if (isset($_REQUEST['type']) && $_REQUEST['type']!=0) {
            $cwhere['`mediainfo`.`type`'] = $_REQUEST['type'];
        }        
        if (isset($_REQUEST['status']) && $_REQUEST['status'] != 0) {
            $cwhere['`mediainfo`.`status`'] = $_REQUEST['status'];
        }         
        return $cwhere;
    }
    
    public function get_mediainfo($where) {
        $this->db->select('*')->from($this->_mediainfo_tb);
        $this->db->where($where);
        $query = $this->db->get();
        $res = $query->result_array();
        foreach ($res as &$value) {
            $value['pic_ids'] = $this->get_media(array(),array('id'=>explode(',',$value['media_id'])));
        }
        return $res;
    }

    /*
     * 更新mediainfo
     */

    public function update_media_info($updata, $where = array()) {
        if ($where) {
            $this->db->where($where);
        }
        $this->db->update($this->_mediainfo_tb, $updata);
        return $this->db->affected_rows();
    }

    /*
     * 更新状态
     */

    public function update_status($updata, $where = array()) {
        if ($where) {
            $this->db->where_in('id', $where);
        }
        $this->db->update($this->_mediainfo_tb, $updata);
        return $this->db->affected_rows();
    }
    
}
